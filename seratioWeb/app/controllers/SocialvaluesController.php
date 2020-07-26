<?php

class SocialvaluesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if(Auth::user()->has_role('admin')){
			$socialvalues = Socialvalue::all();
			if($socialvalues) {
				return View::make('socialvalue.index')
					->with('socialvalues', $socialvalues);
			} else {
				App::abort(404);
			}
		} elseif(Auth::user()->has_role('public') || Auth::user()->has_role('private') || Auth::user()->has_role('third')) {

			$socialvalues = Socialvalue::where('user_id', Auth::id())->get();
			if($socialvalues) {
				return View::make('socialvalue.index')
					->with('socialvalues', $socialvalues);
			} else {
				App::abort(404);
			}

		} else {
			App::abort(404);
		}

	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{

		if(Auth::user()->has_role('admin')){

			return View::make('socialvalue.add');

		} elseif(Auth::user()->has_role('public') || Auth::user()->has_role('private') || Auth::user()->has_role('third')) {

			$socialvalues = Socialvalue::where('user_id', Auth::id())->orderBy('created_at', 'desc')->first();

			if($socialvalues){
				$socialvalues = $socialvalues->toArray();
				 if($socialvalues['ser'] == null || $socialvalues['ser'] == 0) {
					return Redirect::route('socialvalue.index')
						->with('message', 'You can only add a new entry after getting the previous entry result')
						->with('socialvalues', $socialvalues);

				} else {
					return View::make('socialvalue.add');
				}

			} else {
				return View::make('socialvalue.add');
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
		$rules = array(
			'positive'											=> 'required|numeric',
			'neutral'											=>	'required|numeric',
			'negative'											=>	'required|numeric',
			'sentiment_date'									=>	'required',
			'csr'												=>	'required|numeric',
			'deg_of_separation'									=>	'required|numeric',
			'shares'											=>	'required|numeric',
			'capititilization_NAV'								=>	'required|numeric',
			'staff'												=>	'required|numeric',
			'carbon_reduction_t'								=>	'required|numeric',
			'carbon_offset'										=>	'required|numeric',
			'value_tCO2e_non_traded'							=>	'required|numeric',
			'value_tCO2e_traded'								=>	'required|numeric',
			'people'											=>	'required|numeric',
			'money_leveraged'									=>	'required|numeric',
			'current_year_directors_salary_executive'			=> 	'required|numeric',
			'current_year_directors_salary_non_executive'		=>	'required|numeric',
			'current_year_staff_salary'							=>	'required|numeric',
			'current_year_staff_salary_without_directors'		=>	'required|numeric',
			'current_year_tax_charged'							=>	'required|numeric',
			'current_year_total_share_holder_pay_dividend_cash'	=>	'required|numeric',
			'current_year_executive_board'						=>	'required|numeric',
			'current_year_non_executive_board'					=>	'required|numeric',
			'current_year_board_total'							=>	'required|numeric',
			'current_year_number_of_staffs'						=>	'required|numeric',
			'prior_year_directors_salary_executive'				=>	'required|numeric',
			'prior_year_directors_salary_non_executive'			=>	'required|numeric',
			'prior_year_staff_salary'							=>	'required|numeric',
			'prior_year_staff_salary_without_directors'			=>	'required|numeric',
			'prior_year_tax_charged'							=>	'required|numeric',
			'prior_year_total_share_holder_pay_dividend_cash'	=>	'required|numeric',
			'prior_year_executive_board'						=>	'required|numeric',
			'prior_year_non_executive_board'					=>	'required|numeric',
			'prior_year_board_total'							=>	'required|numeric',
			'prior_year_number_of_staffs'						=>	'required|numeric',
			'user_id'											=>	'required|numeric'
		);

		$validator = Validator::make(Input::all(), $rules);

		if($validator->fails()) {
			return Redirect::route('socialvalue.create')
				->withErrors($validator)
				->withInput();
		} else {
			$socialvalue = new Socialvalue($this->socialvalueParams());
			if(Auth::check() && $socialvalue->save()) {
				if(!Auth::user()->has_role('admin')){
					$user = ['organisation'=> Auth::user()->organisation, 'email' => Auth::user()->email, 'phone_number' => Auth::user()->phone_number];
					$data = array_merge($this->socialvalueParams(), $user);
					//dd($data);
					Mail::send('emails.admin', $data, function($message)
					{
					  	$message->to('abhijith.nair@seratio.com', 'Abhijith Nair')->to('sajin.abdu@seratio.com', 'Sajin Abdu')
	          					->subject('New Entry!');
					});
				}
				return Redirect::route('socialvalue.index')
					->with('message', 'You have successfully saved data.');
			} else {
				return Redirect::route('socialvalue.create')->withInput()->withErrors($validator);
			}
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		/*$socialvalue= Socialvalue::find($id);
		if(Auth::user()->has_role('admin') || Auth::user()->socialvalue->contains($socialvalue->id)) {

			$svresult = Svresult::where('socialvalue_id', $socialvalue->id)->get();
			$retCurrent = array();
			foreach($svresult as $result){
				$retCurrent = ['social_impact'=>$result->social_impact,
								'social_impact_asap_cap'=>$result->social_impact_asap_cap,
								'added_value' =>$result->added_value,
								'environment' => $result->environment,
								'people' => $result->people,
								'cash' => $result->cash];
			}
			if($retCurrent) {
				return View ::make('socialvalue.show',
					['socialvalue' 	=> $socialvalue,
					])->with('retCurrent', $retCurrent);
			} else {
				return View::make('socialvalue.show', ['socialvalue'=>$socialvalue]);
			}
		} else {
			App::abort(404);
		}*/
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */

	public function edit($id)
	{
		$socialvalue = Socialvalue::find($id);

		if(Auth::user()->has_role('admin')){

			return View::make('socialvalue.edit')
				->with('socialvalue', $socialvalue);

		} elseif(Auth::user()->has_role('public') || Auth::user()->has_role('private') || Auth::user()->has_role('third')) {

			$socialvalues = DB::table('socialvalues')
				->where('id', $id)
				->where('user_id', Auth::id())
				->get();

			if($socialvalues){
				foreach ($socialvalues as $value) {
					$ser = $value->ser? $value->ser : 0;
					$user_id =$value->user_id ? $value->user_id : null;
				}
				 if($ser == 0 && $user_id == Auth::id()) {
					return View::make('socialvalue.edit')
						->with('socialvalue', $socialvalue);
				} else {
					return Redirect::route('socialvalue.index')
						->with('message', 'You dont have permission to edit this entry. Please contact administrator');
				}

			} return Redirect::route('socialvalue.index')
					->with('message', 'You dont have permission to edit this entry. Please contact administrator');

		} else {
			App::abort(404);
		}

	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		if($id!=0) {

			$rules = array(
				'positive'											=> 'required|numeric',
				'neutral'											=>	'required|numeric',
				'negative'											=>	'required|numeric',
				'sentiment_date'									=>	'required',
				'csr'												=>	'required|numeric',
				'deg_of_separation'									=>	'required|numeric',
				'shares'											=>	'required|numeric',
				'capititilization_NAV'								=>	'required|numeric',
				'staff'												=>	'required|numeric',
				'carbon_reduction_t'								=>	'required|numeric',
				'carbon_offset'										=>	'required|numeric',
				'value_tCO2e_non_traded'							=>	'required|numeric',
				'value_tCO2e_traded'								=>	'required|numeric',
				'people'											=>	'required|numeric',
				'money_leveraged'									=>	'required|numeric',
				'current_year_directors_salary_executive'			=> 	'required|numeric',
				'current_year_directors_salary_non_executive'		=>	'required|numeric',
				'current_year_staff_salary'							=>	'required|numeric',
				'current_year_staff_salary_without_directors'		=>	'required|numeric',
				'current_year_tax_charged'							=>	'required|numeric',
				'current_year_total_share_holder_pay_dividend_cash'	=>	'required|numeric',
				'current_year_executive_board'						=>	'required|numeric',
				'current_year_non_executive_board'					=>	'required|numeric',
				'current_year_board_total'							=>	'required|numeric',
				'current_year_number_of_staffs'						=>	'required|numeric',
				'prior_year_directors_salary_executive'				=>	'required|numeric',
				'prior_year_directors_salary_non_executive'			=>	'required|numeric',
				'prior_year_staff_salary'							=>	'required|numeric',
				'prior_year_staff_salary_without_directors'			=>	'required|numeric',
				'prior_year_tax_charged'							=>	'required|numeric',
				'prior_year_total_share_holder_pay_dividend_cash'	=>	'required|numeric',
				'prior_year_executive_board'						=>	'required|numeric',
				'prior_year_non_executive_board'					=>	'required|numeric',
				'prior_year_board_total'							=>	'required|numeric',
				'prior_year_number_of_staffs'						=>	'required|numeric',
				'user_id'											=>	'required|numeric'
			);

			$validator = Validator::make(Input::all(), $rules);

			if($validator->fails()) {
				return Redirect::route('socialvalue.edit')
					->withErrors($validator)
					->withInput();
			} else {
				$socialvalue = Socialvalue::find($id);
				$updated = $socialvalue->update($this->socialvalueParams());
				if(Auth::check() && $updated) {
					return Redirect::route('socialvalue.index', ['socialvalue' => $socialvalue->id])
						->with('message', 'You have successfully updated data.');
				} else {
					return Redirect::route('socialvalue.edit', ['socialvalue'=>$socialvalue->id])->withInput()->withErrors($validator);
				}
			}
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
		$socialvalue = Socialvalue::find($id);

		$svresult = Svresult::where('socialvalue_id', $id)->get();

		if($svresult->isEmpty() && Auth::user()->has_role('admin') && $socialvalue->delete()){
			return Redirect::route('socialvalue.index')
				->with('message', 'The record has been deleted');
		} else {
			return Redirect::route('socialvalue.index')
				->with('message', 'You dont have access to delete this record. Please contact the site admin');
		}

	}

	private function socialvalueParams() {
		return Input::only(['positive', 'neutral', 'negative', 'sentiment_date',
			'csr', 'deg_of_separation', 'shares', 'capititilization_NAV', 'staff',
			'carbon_reduction_t', 'carbon_offset', 'value_tCO2e_non_traded', 'value_tCO2e_traded',
			'people', 'money_leveraged', 'current_year_directors_salary_executive',
			'current_year_directors_salary_non_executive', 'current_year_staff_salary',
			'current_year_staff_salary_without_directors', 'current_year_tax_charged',
			'current_year_total_share_holder_pay_dividend_cash', 'current_year_executive_board',
			'current_year_non_executive_board', 'current_year_board_total', 'current_year_number_of_staffs',
			'prior_year_directors_salary_executive', 'prior_year_directors_salary_non_executive',
			'prior_year_staff_salary', 'prior_year_staff_salary_without_directors','prior_year_tax_charged',
			'prior_year_total_share_holder_pay_dividend_cash', 'prior_year_executive_board', 'prior_year_non_executive_board',
			'prior_year_board_total', 'prior_year_number_of_staffs', 'user_id' ]);
	}

	public function addResult($id) {

		if(Auth::user()->has_role('admin')) {

			$result = Input::all();
			if(array_key_exists('ser', $result) && array_key_exists('social_impact', $result) && array_key_exists('social_impact_asap_cap', $result) && array_key_exists('added_value', $result) && array_key_exists('environment', $result) && array_key_exists('people_r', $result) && array_key_exists('cash', $result)) {

				$socialvalue 							= Socialvalue::where('id', $id)->first();
				$socialvalue->ser  						= Input::get('ser');
				$socialvalue->social_impact 			= Input::get('social_impact');
				$socialvalue->social_impact_asap_cap 	= Input::get('social_impact_asap_cap');
				$socialvalue->added_value 				= Input::get('added_value');
				$socialvalue->environment 				= Input::get('environment');
				$socialvalue->people 	 				= Input::get('people_r');
				$socialvalue->cash 		 				= Input::get('cash');

				if($socialvalue->save()) {
					Session::flash('message', 'Result updated successfully');
					$user = User::where('id', $socialvalue->user_id)->get();
					foreach($user as $result){
						$result = [$result->email,$result->firstname];

					}
					$email = $result[0] ? $result[0] : 'abhijith0009@gmail.com';
					$firstname = $result[1] ? $result[1] :'Admin';
					Mail::send('emails.customer', $result, function($message) use($email, $firstname)
					{
					  	$message->to($email, $firstname)
	          					->subject('New Entry!');
					});

					return Redirect::route('socialvalue.index');

				} else {
					return Redirect::route('socialvalue.index')
						->with('message', 'There is a problem. Please try again');
				}
			} else {
				return Redirect::route('socialvalue.index')
						->with('message', 'There is a problem. Please try again');
			}
		} else {
			return Redirect::route('socialvalue.index')
						->with('message', 'You dont have permission to do it');
		}
	}

	public function addQuery($id) {

		if(Auth::user()->has_role('admin')) {
			$result = Input::all();

			if(array_key_exists('query', $result)) {
				$socialvalue = Socialvalue::where('id', $id)->first();
				$socialvalue->query = Input::get('query') ? Input::get('query') : 0;

				if($socialvalue->save()) {
					Session::flash('message', 'The status has been changed successfully');
					return Redirect::route('socialvalue.index');
				} else {
					return Redirect::route('socialvalue.index')
						->with('message', 'There is a problem. Please try again');
				}
			} else {
				return Redirect::route('socialvalue.index')
						->with('message', 'There is a problem. Please try again');
			}
		} else {
			App::abort(404);
		}
	}


}
