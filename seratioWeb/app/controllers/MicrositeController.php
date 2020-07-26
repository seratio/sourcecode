<?php

class MicrositeController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		if(Auth::user()->has_role('pslight')) {
			$customer = Microsite::where('user_id', Auth::user()->id)->first();
			$con = Country::countries();
			$currencies = MSlavery::currencies();

			if($customer) {
				return View::make('microsite.customer.basic')
				->with(['customer' => $customer,
					'con' => $con]);
			} else {
				return View::make('ms.customer.index')
				->with(['customer' => null,
					'con' => $con]);
			}
		} else {
			App::abort(404);
		}
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{

	}

	public function showOverview($id) {

		if($id!=0 && Auth::user()->has_role('pslight')) {

			$microsite = Microsite::find($id);

			if($microsite) {
				$microvalue = Microvalue::where('microsite_id', $microsite->id)->first();

				if($microvalue) {
					return View::make('microsite.customer.overview')->with('microsite', $microsite)->with('microvalue', $microvalue);
				} else {

					return Redirect::back()->with('messages', 'No records exist! If this happens again, please contact support');
				}
			} else {
				return Redirect::back()->with('messages', 'No records exist! If this happens again, please contact support');
			}

	    } else {
	    	App::abort(404);
	    }
	}


	public function showSentiment($id) {

		if($id!=0 && Auth::user()->has_role('pslight')) {
			$microsite = Microsite::find($id);
			if($microsite) {
				$microvalue = Microvalue::where('microsite_id', $microsite->id)->first();

				if($microvalue) {
					return View::make('microsite.customer.sentiment')->with('microsite', $microsite)->with('microvalue', $microvalue);
				} else {
					return Redirect::back()->with('messages', 'No records exist! If this happens again, please contact support');
				}
			} else {
				return Redirect::back()->with('messages', 'No records exist! If this happens again, please contact support');
			}

	    } else {
	    	App::abort(404);
	    }
	}

	public function showAll($id) {

		if($id!=0 && Auth::user()->has_role('pslight')) {
			$microsite = Microsite::find($id);
			if($microsite) {
				$microvalue = Microvalue::where('microsite_id', $microsite->id)->first();

				if($microvalue) {

					return View::make('microsite.customer.entries')->with('microsite', $microsite)->with('microvalue', $microvalue);
				} else {
					return Redirect::back()->with('messages', 'No records exist! If this happens again, please contact support');
				}
			} else {
				return Redirect::back()->with('messages', 'No records exist! If this happens again, please contact support');
			}

	    } else {
	    	App::abort(404);
	    }
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//dd(Input::all());
		if( $id!=0  && Auth::user()->has_role('pslight')) {

			$rules = array(
				'customer_name'				=> 'required',
				'number_street'				=> 'required',
				'city'						=> 'required',
				'county'					=> 'required',
				'post_code'					=> 'required',
				'country' 					=> 'required',
				'primary_contact'			=> 'required',
				'number'					=> 'required|numeric',
				'checkbox'					=> 'required|numeric',
				'audited_accounts'			=> 'required_if:checkbox,1',
				'published_accounts'		=> 'required_if:checkbox,2|URL',
				'free_text'					=> 'required_if:checkbox,2',
				'question1'					=> 'numeric',
				'question2'					=> 'numeric',
				'question3'					=> 'numeric',
				'question4'					=> 'numeric',
				'question5'					=> 'numeric',
				);


			$messages = array('required' => 'This field is required',
				'required_if' => 'We are unable to proceed any further without your audited accounts');

			$validator = Validator::make(Input::all(), $rules, $messages);

			if($validator->fails()) {
				return Redirect::back()
				->withErrors($validator)
				->withInput();
			} else {
				$microsite = Microsite::find($id);

				if($microsite) {
					$microsite->customer_name 	= Input::get('customer_name') ? Input::get('customer_name') : null;
					$microsite->number_street = Input::get('number_street') ? Input::get('number_street') : null;
					$microsite->city = Input::get('city') ? Input::get('city') : null;
					$microsite->county = Input::get('county') ? Input::get('county') : null;
					$microsite->post_code = Input::get('post_code') ? Input::get('post_code') : null;
					$microsite->country = Input::get('country') ? Input::get('country') : null;
					$microsite->primary_contact = Input::get('primary_contact') ? Input::get('primary_contact') : null;
					$microsite->number = Input::get('number') ? Input::get('number') : null;
					$microsite->checkbox = Input::get('checkbox') ? Input::get('checkbox') : null;

					$microsite->question1 = Input::get('question1') ? Input::get('question1') : 0;
					$microsite->question2 = Input::get('question2') ? Input::get('question2') : 0;
					$microsite->question3 = Input::get('question3') ? Input::get('question3') : 0;
					$microsite->question4 = Input::get('question4') ? Input::get('question4') : 0;
					$microsite->question5 = Input::get('question5') ? Input::get('question5') : 0;

					$audited_accounts = Input::file('audited_accounts');

					if($audited_accounts){
						$size = $audited_accounts->getSize();
						if($size > 1048576 * 2) {
							return Redirect::back()->withInput()->with('message', 'File is too large. File must be less than 2MB in size')->with('error_code', 5);
						} else {
							$path = public_path(). "/uploads/pslight/customers/".$microsite->id."/";

							if(!file_exists($path)) {
								mkdir($path, 0777, true);
							}

							if($microsite->audited_accounts) {
								$existing = public_path()."/".$microsite->audited_accounts;
								File::delete($existing);
								$microsite->audited_accounts = null;

							}

							Input::file('audited_accounts')->move($path . "/", $audited_accounts->getClientOriginalName());
							$microsite->audited_accounts = "uploads/pslight/customers/".$microsite->id."/".$audited_accounts->getClientOriginalName();
							$microsite->published_accounts = null;
							$microsite->free_text = null;

						}
					} else {
						$microsite->audited_accounts = null;
						$microsite->published_accounts = Input::get('published_accounts') ? Input::get('published_accounts') : null;
						$microsite->free_text = Input::get('free_text') ? Input::get('free_text') : null;

					}

					if($microsite->save()) {
						return Redirect::back()->with('message', 'Thank You, We will have your baseline score within 7 business days. If for any reason there is not enough information we will contact you but it may delay the process');
					} else {
						return Redirect::back()->with('message', 'Something went wrong, Please try again. If this happens again please contact support');
					}

				} else {
					App::abort(404);
				}
			}

		} else {
			App::abort(404);
		}
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function viewUsers() {

		if(Auth::user()->has_role('admin')) {
			$users = User::where('role_id', '=', '9')->get();
			$data = [];
			foreach($users as $user){
				if($user->microsite){
					$data[$user->id] = $user;
				}
			}
			if($data) {
				return View::make('microsite.admin.users')->with('data', $data);
			} else {
				App::abort(404);
			}
		} else {
			App::abort(404);
		}
	}

	public function addResult($id) {
		if(Auth::user()->has_role('admin')) {
			$microsite = Microsite::find($id);
			if($microsite){
				$microvalue = Microvalue::where('microsite_id', $microsite->id)->first();

				if($microvalue) {
					return View::make('microsite.admin.addresult')->with('microvalue', $microvalue)->with('microsite', $microsite);
				} else {
					return Redirect::back()->with('message', "Sorry, We couldn't find the record. If this happend again please contact admin")->with('microvalue', $microvalue);
				}
			} else {
				return Redirect::back()->with('message', 'Something went wrong, Please try again');
			}

		} else {
			App::abort();
		}
	}

	public function updateResult($id) {
		if (Auth::user()->has_role('admin') && $id!=0) {

			$rules = array(
				'targeted_audience'									=> 'required',
				'positive'											=> 'required|numeric',
				'neutral'											=>	'required|numeric',
				'negative'											=>	'required|numeric',
				'sentiment_date'									=>	'required',
				'non_statutory_spend'								=>	'required|numeric',
				'no_of_service_users'								=>	'required|numeric',
				'net_asset_value'									=>	'required|numeric',
				'staff'												=>	'required|numeric',
				'carbon_reduction_t'								=>	'required|numeric',
				'carbon_offset'										=>	'required|numeric',
				'people'											=>	'required|numeric',
				'money_leveraged'									=>	'required|numeric',
				'cu_directors_salary'								=> 	'required|numeric',
				'cu_members_salary'									=>	'required|numeric',
				'cu_staff_salary_bill'								=>	'required|numeric',
				'cu_executive_board'								=>	'required|numeric',
				'cu_total_counc_members'							=>	'required|numeric',
				'cu_total_board_senior_directors'					=>	'required|numeric',
				'cu_total_staff'									=>	'required|numeric',
				'py_directors_salary'								=>	'required|numeric',
				'py_members_salary'									=>	'required|numeric',
				'py_staff_salary_bill'								=>	'required|numeric',
				'py_executive_board'								=>	'required|numeric',
				'py_total_counc_members'							=>	'required|numeric',
				'py_total_board_senior_directors'					=>	'required|numeric',
				'py_total_staff'									=>	'required|numeric',
				'user_id'											=>	'required|numeric',
				'ser'												=> 	'required|numeric',
				'social_impact'										=>  'required|numeric',
				'social_impact_asap_cap'							=>  'required|numeric',
				'added_value'										=> 	'required|numeric'
				);

		$validator = Validator::make(Input::all(), $rules);

		if($validator->fails()) {
			return $validator->messages()->toJson();
			return Redirect::back()
			->withErrors($validator)
			->withInput();
		} else {
			$microvalue = Microvalue::where('microsite_id', $id)->first();
			$updated = $microvalue->update($this->siteParams());
			if(Auth::check() && $updated) {
				return Redirect::back()
				->with('message', 'You have successfully saved data.');
			} else {

				return Redirect::back()->withInput()->withErrors($validator);
			}
		}
	}
}

private function siteParams() {
	return Input::only(['targeted_audience','positive', 'neutral', 'negative', 'sentiment_date',
		'non_statutory_spend', 'no_of_service_users', 'net_asset_value', 'staff',
		'carbon_reduction_t', 'carbon_offset','people', 'money_leveraged', 'cu_directors_salary',
		'cu_members_salary', 'cu_staff_salary_bill', 'cu_executive_board',
		'cu_total_counc_members', 'cu_total_board_senior_directors',
		'cu_total_staff','py_directors_salary', 'py_members_salary',
		'py_staff_salary_bill', 'py_executive_board','py_total_counc_members',
		'py_total_board_senior_directors', 'py_total_staff',
		'user_id', 'ser', 'social_impact', 'social_impact_asap_cap', 'added_value']);
}


}
