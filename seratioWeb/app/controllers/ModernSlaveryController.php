<?php

class ModernSlaveryController extends \BaseController {

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
		if(Auth::user()->has_role('admin') || (Auth::user()->has_role('ms') && Auth::user()->has_subrole('customer'))) {
			$customer = Mscustomer::where('user_id', Auth::user()->id)->first();
			$current_url = URL::full();
			$basic 	= strpos($current_url, 'basic') ? TRUE : FALSE;
			$pay    = strpos($current_url, 'pay') ? TRUE : FALSE;
			$sentiment = strpos($current_url, 'sentiment') ? TRUE : FALSE;
			$statement = strpos($current_url, 'statement') ? TRUE : FALSE;
			$sectors  = MSlavery::sectors();
			$industries = MSlavery::industries();
			$con = Country::countries();
			$currencies = MSlavery::currencies();
			$known      = MSlavery::knownSuppliers();
			$ms = Mscustomer::where('user_id', Auth::user()->id)->first();
			if($customer) {
				return View::make('ms.customer.index')
				->with(['customer' => $customer,
					'basic'   => $basic,
					'pay'	  => $pay,
					'sentiment'=> $sentiment,
					'statement'=> $statement,
					'sectors' => $sectors,
					'industries' => $industries,
					'con' => $con,
					'currencies' => $currencies,
					'ms'		=> $ms,
					'known'		=> $known]);
			} else {
				return View::make('ms.customer.index')
				->with(['customer' => null,
					'basic'   => $basic,
					'pay'	  => $pay,
					'sentiment'=> $sentiment,
					'statement' => $statement,
					'sectors' => $sectors,
					'industries' => $industries,
					'con' => $con,
					'currencies' => $currencies,
					'ms'		=> $ms,
					'known' 	=> $known]);
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
		$section = Input::get('type');

		if($section == "basic") {

			$rules = array(
				'customer_name' 					=> 'required',
				'number_street'						=> 'required',
				'city'								=> 'required',
				'county'							=> 'required',
				'post_code'							=> 'required',
				'country' 							=> 'required',
				'primary_contact'					=> 'required',
				'number'							=> 'required|numeric',
				'sector'							=> 'required',
				'main_industry'						=> 'required'
				);

			$validator = Validator::make(Input::all(), $rules);

			if($validator->fails()) {
				return Redirect::back()
				->withErrors($validator)
				->withInput();
			} else {
				$mscustomer = Mscustomer::where('user_id', Auth::user()->id)->first();
				if($mscustomer) {
					$mscustomer->customer_name   = Input::get('customer_name') ? Input::get('customer_name') : $mscustomer->customer_name;
					$mscustomer->number_street   = Input::get('number_street') ? Input::get('number_street') : $mscustomer->number_street;
					$mscustomer->city 		     = Input::get('city') ? Input::get('city') : $mscustomer->city;
					$mscustomer->county          = Input::get('county') ? Input::get('county') : $mscustomer->county;
					$mscustomer->post_code 	     = Input::get('post_code') ? Input::get('post_code') : $mscustomer->post_code;
					$mscustomer->country 	   	 = Input::get('country') ? Input::get('country') : $mscustomer->country;
					$mscustomer->primary_contact = Input::get('primary_contact') ? Input::get('primary_contact') : $mscustomer->primary_contact;
					$mscustomer->number          = Input::get('number') ? Input::get('number') :$mscustomer->number;
					$mscustomer->sector          = Input::get('sector') ? Input::get('sector') : $mscustomer->sector;
					$mscustomer->main_industry   = Input::get('main_industry') ? Input::get('main_industry') : $mscustomer->main_industry;
					$mscustomer->save();

					return Redirect::back()->with('message', 'You have successfully added basic info');

					//return Redirect::route('modernslavery.create', 'pay')->with('message', 'You have successfully added the basic info. Please complete below section');


				} else {
					return Redirect::back()->with('message', 'Something went wrong');
				}
			}


		} elseif($section == "pay") {


			$rules = array(
				'currency' 							=> 'required',
				'total_revenue'						=> 'numeric',
				'total_wages'						=> 'numeric',
				'no_of_employees'					=> 'numeric',
				'no_of_pt_employees'				=> 'numeric',
				'total_pt_hours' 					=> 'numeric',
				'total_pt_wages'					=> 'numeric'
				);

			$validator = Validator::make(Input::all(), $rules);

			if($validator->fails()) {
				return Redirect::back()
				->withErrors($validator)
				->withInput();
			} else {
				$mscustomer = Mscustomer::where('user_id', Auth::user()->id)->first();
				if($mscustomer) {
					$mscustomer->currency   		 = Input::get('currency') ? Input::get('currency') : $mscustomer->currency;
					$mscustomer->total_revenue   	 = Input::get('total_revenue') ? Input::get('total_revenue') : $mscustomer->total_revenue;
					$mscustomer->total_wages 		 = Input::get('total_wages') ? Input::get('total_wages') : $mscustomer->total_wages;
					$mscustomer->no_of_employees   	 = Input::get('no_of_employees') ? Input::get('no_of_employees') : $mscustomer->no_of_employees;
					$mscustomer->no_of_pt_employees  = Input::get('no_of_pt_employees') ? Input::get('no_of_pt_employees') : $mscustomer->no_of_pt_employees;
					$mscustomer->total_pt_hours 	 = Input::get('total_pt_hours') ? Input::get('total_pt_hours') : $mscustomer->total_pt_hours;
					$mscustomer->total_pt_wages 	 = Input::get('total_pt_wages') ? Input::get('total_pt_wages') : $mscustomer->total_pt_wages;
					$mscustomer->save();
					return Redirect::back()->with('message', 'You have successfully added Pay Details');
					//return Redirect::route('modernslavery.create', 'se')->with('message', 'You have successfully completed the Pay info. Please complete below section');
				} else {
					return Redirect::back()->with('message', 'Something went wrong');
				}
			}

		} elseif($section == "sentiment") {

			$rules = array(
				'sentiment_q1' => 'required',
				'sentiment_q1' => 'numeric',
				'sentiment_q3' => '',
				'sentiment_q4' => 'numeric');

			$validator = Validator::make(Input::all(), $rules);

			if($validator->fails()){
				return Redirect::back()
				->withErrors($validator)
				->withInput();
			} else {
				$mscustomer = Mscustomer::where('user_id', Auth::user()->id)->first();
				if($mscustomer) {
					$mscustomer->sentiment_q1   		= Input::get('sentiment_q1') ? Input::get('sentiment_q1') : $mscustomer->sentiment_q1;
					$mscustomer->sentiment_q2   	 	= Input::get('sentiment_q2') ? Input::get('sentiment_q2') : $mscustomer->sentiment_q2;
					$mscustomer->sentiment_q3 		    = Input::get('sentiment_q3') ? Input::get('sentiment_q3') : $mscustomer->sentiment_q3;
					$mscustomer->sentiment_q4   	 	= Input::get('sentiment_q4') ? Input::get('sentiment_q4') : $mscustomer->sentiment_q4;
					$mscustomer->save();
					return Redirect::back()->with('message', 'You have successfully added Sentiment Details');
				} else {
					return Redirect::back()->with('message', 'Something went wrong');
				}
			}

		} else {
			App::abort(404);
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
		if(Auth::user()->has_role('admin')) {
			$customer = Mscustomer::find($id);

			if($customer) {
				$suppliers = Mssupplier::where('customer_id', $customer->id)->get();
				$surveys = Mssurvey::where('customer_number', $customer->customer_number)->get();
				$customer_surveys = Mscustomersurvey::where('customer_number', $customer->customer_number)->get();

				$ms = DB::select(DB::raw("SELECT
					SUM(CASE WHEN customer_name IS NOT NULL THEN 1 ELSE 0 END)/COUNT(*)*100 AS customer_name,
					SUM(CASE WHEN number_street IS NOT NULL THEN 1 ELSE 0 END)/COUNT(*)*100 AS number_street,
					SUM(CASE WHEN city IS NOT NULL THEN 1 ELSE 0 END)/COUNT(*)*100 AS city,
					SUM(CASE WHEN county IS NOT NULL THEN 1 ELSE 0 END)/COUNT(*)*100 AS county,
					SUM(CASE WHEN post_code IS NOT NULL THEN 1 ELSE 0 END)/COUNT(*)*100 AS post_code,
					SUM(CASE WHEN country IS NOT NULL THEN 1 ELSE 0 END)/COUNT(*)*100 AS country,
					SUM(CASE WHEN primary_contact IS NOT NULL THEN 1 ELSE 0 END)/COUNT(*)*100 AS primary_contact,
					SUM(CASE WHEN number IS NOT NULL THEN 1 ELSE 0 END)/COUNT(*)*100 AS number,
					SUM(CASE WHEN sector IS NOT NULL THEN 1 ELSE 0 END)/COUNT(*)*100 AS sector,
					SUM(CASE WHEN main_industry IS NOT NULL THEN 1 ELSE 0 END)/COUNT(*)*100 AS main_industry,
					SUM(CASE WHEN currency IS NOT NULL THEN 1 ELSE 0 END)/COUNT(*)*100 AS currency,
					SUM(CASE WHEN total_revenue IS NOT NULL THEN 1 ELSE 0 END)/COUNT(*)*100 AS total_revenue,
					SUM(CASE WHEN total_wages IS NOT NULL THEN 1 ELSE 0 END)/COUNT(*)*100 AS total_wages,
					SUM(CASE WHEN no_of_employees IS NOT NULL THEN 1 ELSE 0 END)/COUNT(*)*100 AS no_of_employees,
					SUM(CASE WHEN document1 IS NOT NULL THEN 1 ELSE 0 END)/COUNT(*)*100 AS document1
					FROM  mscustomers where id = '$customer->id'"));

					if($ms) {

					foreach ($ms as $ms) {
					}
						$basic_info = ($ms->customer_name+$ms->number_street+$ms->city+$ms->county+$ms->post_code+$ms->country+$ms->primary_contact+$ms->number+$ms->sector+$ms->main_industry)/10;
						$pay  = ($ms->currency+$ms->total_revenue+$ms->total_wages+$ms->no_of_employees+$ms->document1)/5;

					} else {
						$basic_info = 0;
						$pay = 0;
					}
					$sentiment = $customer->sentiment ? 100 : 0;

				return View::make('ms.customer.show')->with('customer', $customer)->with('surveys', $surveys)->with('suppliers', $suppliers)->with('customer_surveys', $customer_surveys)
													 ->with('basic_info', $basic_info)->with('pay', $pay)->with('sentiment', $sentiment);
			} else {
				return Redirect::back()->with('message', 'Something went wrong. Please try again');
			}
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

		$mscustomer = Mscustomer::find($id);

		if(Auth::user()->has_role('ms') && Auth::user()->has_subrole('customer') && $mscustomer) {
			$section = Input::get('type');

			if($section == "basic") {

				$rules = array(
					'customer_name' 					=> 'required',
					'number_street'						=> 'required',
					'city'								=> 'required',
					'county'							=> 'required',
					'post_code'							=> 'required',
					'country' 							=> 'required',
					'primary_contact'					=> 'required',
					'number'							=> 'required|numeric',

					'sector'							=> 'required',
					'main_industry'						=> 'required'
					);

				$validator = Validator::make(Input::all(), $rules);

				if($validator->fails()) {
					return Redirect::back()
					->withErrors($validator)
					->withInput();
				} else {

					$mscustomer->customer_name   = Input::get('customer_name') ? Input::get('customer_name') : $mscustomer->customer_name;
					$mscustomer->number_street   = Input::get('number_street') ? Input::get('number_street') : $mscustomer->number_street;
					$mscustomer->city 		     = Input::get('city') ? Input::get('city') : $mscustomer->city;
					$mscustomer->county          = Input::get('county') ? Input::get('county') : $mscustomer->county;
					$mscustomer->post_code 	     = Input::get('post_code') ? Input::get('post_code') : $mscustomer->post_code;
					$mscustomer->country 	   	 = Input::get('country') ? Input::get('country') : $mscustomer->country;
					$mscustomer->primary_contact = Input::get('primary_contact') ? Input::get('primary_contact') : $mscustomer->primary_contact;
					$mscustomer->number          = Input::get('number') ? Input::get('number') :$mscustomer->number;

					$mscustomer->sector          = Input::get('sector') ? Input::get('sector') : $mscustomer->sector;
					$mscustomer->main_industry   = Input::get('main_industry') ? Input::get('main_industry') : $mscustomer->main_industry;

					if($mscustomer->save()) {
						return Redirect::back()
						->with('message', 'You have successfully updated basic info');
					} else {
						return Redirect::back()
						->with('message', 'There is some problem, Please try again');
					}

				}


			} elseif($section == "pay") {


				$file = Input::file('document1');

				$rules = array(
					'currency' 							=> 'required',
					'total_revenue'						=> 'required|numeric',
					'total_wages'						=> 'required|numeric',
					'no_of_employees'					=> 'required|numeric',
					'no_of_pt_employees'				=> 'numeric',
					'total_pt_hours' 					=> 'numeric',
					'total_pt_wages'					=> 'numeric',
					'document1' 						=> 'mimes:txt,pdf,doc,xls,ppt,rtf',
					);



				$validator = Validator::make(Input::all(), $rules);

				if($validator->fails()) {
					return Redirect::back()
					->withErrors($validator)
					->withInput();
				} else {

					$mscustomer->currency   		 = Input::get('currency') ? Input::get('currency') : $mscustomer->currency;
					$mscustomer->total_revenue   	 = Input::get('total_revenue') ? Input::get('total_revenue') : $mscustomer->total_revenue;
					$mscustomer->total_wages 		 = Input::get('total_wages') ? Input::get('total_wages') : $mscustomer->total_wages;
					$mscustomer->no_of_employees   	 = Input::get('no_of_employees') ? Input::get('no_of_employees') : $mscustomer->no_of_employees;
					$mscustomer->no_of_pt_employees  = Input::get('no_of_pt_employees') ? Input::get('no_of_pt_employees') : $mscustomer->no_of_pt_employees;
					$mscustomer->total_pt_hours 	 = Input::get('total_pt_hours') ? Input::get('total_pt_hours') : $mscustomer->total_pt_hours;
					$mscustomer->total_pt_wages 	 = Input::get('total_pt_wages') ? Input::get('total_pt_wages') : $mscustomer->total_pt_wages;


					if($file) {

						$size = $file->getSize();

						if($size > 1048576 * 2) {
							return Redirect::back()->withInput()->with('message', 'File is too large. File must be less than 2MB in size');
						} else {
							$path = public_path(). "/uploads/customers/".$mscustomer->customer_number;

							if(!file_exists($path)) {
								mkdir($path, 0777, true);
							}

							if($mscustomer->document1) {
								$existing = public_path()."/".$mscustomer->document1;
								File::delete($existing);
								$mscustomer->document1 = null;

							}

							Input::file('document1')->move($path . "/", $file->getClientOriginalName());
							$mscustomer->document1 = "uploads/customers/".$mscustomer->customer_number."/".$file->getClientOriginalName();

						}
					}

					if($mscustomer->save()) {
						return Redirect::back()
						->with('message', 'You have successfully updated basic info');
					} else {
						return Redirect::back()
						->with('message', 'There is some problem, Please try again');
					}


				}

			} elseif($section == "sentiment") {



				$rules = array(
					'sentiment_q1' => 'required',
					'sentiment_q1_sub' => '',
					'sentiment_q2' 	=> 'numeric',
					'sentiment_q3'	=> 'numeric',
					'sentiment_q4' 	=> '',
					);

				$validator = Validator::make(Input::all(), $rules);


				if($validator->fails()) {
					return Redirect::back()
					->withErrors($validator)
					->withInput();
				} else {
					$sentiment_q1 = Input::get('sentiment_q1') ? Input::get('sentiment_q1') : null;
					$sentiment_q1_sub = Input::get('sentiment_q1_sub') ? Input::get('sentiment_q1_sub') : null;
					$mscustomer->sentiment_q1   		=  $sentiment_q1;
					if($mscustomer->sentiment_q1 == 1){
						$mscustomer->sentiment_q1_sub   		=  $sentiment_q1_sub;

					} else {
						$mscustomer->sentiment_q1_sub = null;
						$mscustomer->sentiment_q2  = null;
						$mscustomer->sentiment_q3  = null;
						$mscustomer->sentiment_q4  = null;
					}
					if($sentiment_q1_sub == 4) {
						$mscustomer->sentiment_q2  = Input::get('sentiment_q2');
						$mscustomer->sentiment_q3  = Input::get('sentiment_q3');
						$mscustomer->sentiment_q4  = Input::get('sentiment_q4');
					} else {
						$mscustomer->sentiment_q2  = null;
						$mscustomer->sentiment_q3  = null;
						$mscustomer->sentiment_q4  = null;
					}
					$mscustomer->save();


					if($mscustomer->sentiment_q1 == 2 || $mscustomer->sentiment_q1_sub == 3) {



						if(!Auth::user()->has_role('admin')){

							$customer = Mscustomer::where('customer_number', $mscustomer->customer_number)->first();

							$customer_name = $customer->customer_name;

							$customer_data = ['customer_number' => $customer->customer_number, 'customer_name' => $customer->customer_name];

							Mail::send('emails.cussurvey', $customer_data, function($message) use($customer)
							{
								$message->to(Auth::user()->email, $customer->customer_name)
								->subject('Modern Slavery - Please complete the Sentiment Survey');
							});

						}
						return Redirect::back()->with('message', 'Your inputs have been saved. An email has been sent to you to complete the sentiment survey');

					} else {
						return Redirect::back()->with('message', 'You have successfully added Sentiment Details');
					}

				}



			} elseif($section == "statement") {

				//dd(Input::all());
				$rules = array(
					'nature_of_your_business' 			=> 'required',
					'policies' 							=> 'required',
					'checkbox1'							=> 'required',
					'checkbox2'							=> 'required',
					'checkbox3'							=> 'required',
					'checkbox5' 						=> 'required',
					'checkbox6'							=> 'required',
					'checkbox7'							=> 'required',
					'checkbox8'							=> 'required',
					'checkbox9'							=> 'required',
					'checkbox10'						=> 'required',
					'checkbox11'						=> 'required',
					'checkbox12'						=> 'required',
					'checkbox13'						=> 'required',
					'checkbox14'						=> 'required',
					'checkbox15'						=> 'required',
					'known_supp'						=> 'required',
					'checkbox16'						=> 'required',
					'external_auditors'					=> 'required',
					'instances'							=> 'required',
					'checkbox17'						=> 'required',
					'technology_platforms'				=> 'required'
					);

				$validator = Validator::make(Input::all(), $rules);

				if($validator->fails()) {
					return Redirect::back()
					->withErrors($validator)
					->withInput();
				} else {

					//dd(implode(", ", Input::get('checkbox1')));
					$mscustomer->nature_of_your_business   		= Input::get('nature_of_your_business') ? Input::get('nature_of_your_business') : $mscustomer->nature_of_your_business;
					$mscustomer->policies  				  		= Input::get('policies') ? Input::get('policies') : $mscustomer->policies;
					$mscustomer->checkbox1 		    		   	= Input::get('checkbox1') ? implode(", ", Input::get('checkbox1')) : $mscustomer->checkbox1;
					$mscustomer->checkbox2 		    		   	= Input::get('checkbox2') ? implode(", ", Input::get('checkbox2')) : $mscustomer->checkbox2;
					$mscustomer->checkbox3 		    		   	= Input::get('checkbox3') ? implode(", ", Input::get('checkbox3')) : $mscustomer->checkbox3;
					$mscustomer->checkbox5 		    		   	= Input::get('checkbox5') ? implode(", ", Input::get('checkbox5')) : $mscustomer->checkbox5;
					$mscustomer->checkbox6 		    		   	= Input::get('checkbox6') ? implode(", ", Input::get('checkbox6')) : $mscustomer->checkbox6;
					$mscustomer->checkbox7 		    		   	= Input::get('checkbox7') ? implode(", ", Input::get('checkbox7')) : $mscustomer->checkbox7;
					$mscustomer->checkbox8 		    		   	= Input::get('checkbox8') ? implode(", ", Input::get('checkbox8')) : $mscustomer->checkbox8;
					$mscustomer->checkbox9 		    		   	= Input::get('checkbox9') ? implode(", ", Input::get('checkbox9')) : $mscustomer->checkbox9;
					$mscustomer->checkbox10 		    		= Input::get('checkbox10') ? implode(", ", Input::get('checkbox10')) : $mscustomer->checkbox10;
					$mscustomer->checkbox11		    		   	= Input::get('checkbox11') ? implode(", ", Input::get('checkbox11')) : $mscustomer->checkbox11;
					$mscustomer->checkbox12 		    		= Input::get('checkbox12') ? implode(", ", Input::get('checkbox12')) : $mscustomer->checkbox12;
					$mscustomer->checkbox13 		    		= Input::get('checkbox13') ? implode(", ", Input::get('checkbox13')) : $mscustomer->checkbox13;
					$mscustomer->checkbox14 		    		= Input::get('checkbox14') ? implode(", ", Input::get('checkbox14')) : $mscustomer->checkbox14;
					$mscustomer->checkbox15 		    		= Input::get('checkbox15') ? implode(", ", Input::get('checkbox15')) : $mscustomer->checkbox15;
					$mscustomer->known_supp 		    		= Input::get('known_supp') ? Input::get('known_supp') : $mscustomer->known_supp;
					$mscustomer->checkbox16 		    		= Input::get('checkbox16') ? implode(", ", Input::get('checkbox16')) : $mscustomer->checkbox16;
					$mscustomer->external_auditors 		    	= Input::get('external_auditors') ? Input::get('external_auditors') : $mscustomer->external_auditors;
					$mscustomer->instances 		    		   	= Input::get('instances') ? Input::get('instances') : $mscustomer->instances;
					$mscustomer->checkbox17 		    		= Input::get('checkbox17') ?implode(", ", Input::get('checkbox17')) : $mscustomer->checkbox17;
					$mscustomer->technology_platforms 		   	= Input::get('technology_platforms') ? Input::get('technology_platforms') : $mscustomer->technology_platforms;

					if($mscustomer->instances == 'Yes'){
							$mscustomer->free_text 	= Input::get('free_text') ? Input::get('free_text') : $mscustomer->free_text;
					} else{
							$mscustomer->free_text 	= null;
					}

					if($mscustomer->save()) {
						return Redirect::back()
						->with('message', 'You have successfully updated the Statement');
					} else {
						return Redirect::back()
						->with('message', 'There is some problem, Please try again');
					}

				}

			} else {
				App::abort(404);
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
		//
	}

	public function addResult($id) {

		if($id && Auth::user()->has_role('admin')){
			$customer = Mscustomer::find($id);
			$customer->modern_slavery = Input::get('modern_slavery') ? Input::get('modern_slavery') : null;
			$customer->sentiment = Input::get('sentiment') ? Input::get('sentiment') : null;
			if($customer->save()) {
				return Redirect::back()->with('message', 'You have successfully added results');
			} else {
				return Redirect::back()->with('message', 'Something went wrong, Please try again');
			}
		} else {
			App::abort(404);
		}
	}

	private function msParams() {
		return Input::only(['user_id', 'customer_name', 'number_street', 'city', 'county',
			'post_code', 'country', 'primary_contact', 'number', 'email',
			'sector', 'main_industry', 'currency', 'total_revenue', 'total_wages',
			'no_of_employees', 'no_of_pt_employees', 'total_pt_hours', 'total_pt_wages',
			'sentiment_q1', 'sentiment_q2', 'sentiment_q3', 'sentiment_q4', 'document1',
			'document2', 'document3', 'document4', 'document5']);
	}

	public function viewUsers() {

		if(Auth::user()->has_role('admin')) {
			$users = User::where('role_id', '=', '8')->get();

			if($users) {
				return View::make('ms.admin.users')->with('users', $users);
			} else {
				App::abort(404);
			}
		} else {
			App::abort(404);
		}
	}

	public function showReport($id) {

		if(Auth::user()->has_role('ms') && Auth::user()->has_subrole('customer')) {

			$ms = Mscustomer::find($id);

			if($ms) {
				$suppliers = Mssupplier::where('user_id', Auth::user()->id)->get();
				//$customer = Mscustomer::where('user_id', Auth::user()->id)->get();

				$customer = DB::select(DB::raw("SELECT
					SUM(CASE WHEN customer_name IS NOT NULL THEN 1 ELSE 0 END)/COUNT(*)*100 AS customer_name,
					SUM(CASE WHEN number_street IS NOT NULL THEN 1 ELSE 0 END)/COUNT(*)*100 AS number_street,
					SUM(CASE WHEN city IS NOT NULL THEN 1 ELSE 0 END)/COUNT(*)*100 AS city,
					SUM(CASE WHEN county IS NOT NULL THEN 1 ELSE 0 END)/COUNT(*)*100 AS county,
					SUM(CASE WHEN post_code IS NOT NULL THEN 1 ELSE 0 END)/COUNT(*)*100 AS post_code,
					SUM(CASE WHEN country IS NOT NULL THEN 1 ELSE 0 END)/COUNT(*)*100 AS country,
					SUM(CASE WHEN primary_contact IS NOT NULL THEN 1 ELSE 0 END)/COUNT(*)*100 AS primary_contact,
					SUM(CASE WHEN number IS NOT NULL THEN 1 ELSE 0 END)/COUNT(*)*100 AS number,
					SUM(CASE WHEN sector IS NOT NULL THEN 1 ELSE 0 END)/COUNT(*)*100 AS sector,
					SUM(CASE WHEN main_industry IS NOT NULL THEN 1 ELSE 0 END)/COUNT(*)*100 AS main_industry,
					SUM(CASE WHEN currency IS NOT NULL THEN 1 ELSE 0 END)/COUNT(*)*100 AS currency,
					SUM(CASE WHEN total_revenue IS NOT NULL THEN 1 ELSE 0 END)/COUNT(*)*100 AS total_revenue,
					SUM(CASE WHEN total_wages IS NOT NULL THEN 1 ELSE 0 END)/COUNT(*)*100 AS total_wages,
					SUM(CASE WHEN no_of_employees IS NOT NULL THEN 1 ELSE 0 END)/COUNT(*)*100 AS no_of_employees,
					SUM(CASE WHEN document1 IS NOT NULL THEN 1 ELSE 0 END)/COUNT(*)*100 AS document1
					FROM  mscustomers where id = '$ms->id'"));

if($customer) {
	foreach ($customer as $customer) {
	}

	$basic_info = ($customer->customer_name+$customer->number_street+$customer->city+$customer->county+$customer->post_code+$customer->country+$customer->primary_contact+$customer->number+$customer->sector+$customer->main_industry)/10;
	$pay  = ($customer->currency+$customer->total_revenue+$customer->total_wages+$customer->no_of_employees+$customer->document1)/5;


} else {
	$basic_info = 0;
	$pay = 0;
}

$sentiment = $ms->sentiment ? 100 : 0;

return View::make('ms.customer.report')->with('ms', $ms)->with('basic_info', $basic_info)->with('pay', $pay)->with('sentiment', $sentiment);
} else {
	App::abort(404);
}
} else {
	App::abort(404);
}
}

public function getCustomerSurvey($id) {
	if($id) {
		$customer = Mscustomer::where('customer_number', $id)->first();
		$con = Country::countries();

		if ($customer){

			return View::make('ms.customer_survey')->with('con', $con)->with('customer', $customer);
		} else {
			return View::make('ms.customer_survey');
		}

	} else {
		App::abort(404);
	}

}

public function saveCustomerSurvey($id) {

	if($id) {
		$rules  = array(
			'customer_number' 			=> 'required',
			'country' 					=> 'required',
			'question_1'				=> 'required',
			'question_2'				=> 'required',
			'question_3'				=> 'required',
			'question_4'				=> 'required',
			'question_5'				=> 'required',
			'question_6'				=> 'required',
			'question_7'				=> 'required',
			'question_8'				=> 'required',
			'question_9'				=> 'required',
			'question_10'				=> 'required',
			);

		$validator = Validator::make(Input::all(), $rules);

		if($validator->fails()) {
			return Redirect::back()
			->withInput()
			->withErrors($validator);
		} else {

			$survey = new Mscustomersurvey;
			$survey->customer_id        	=	$id;
			$survey->customer_number		= 	Input::get('customer_number');
			$survey->country 				= 	Input::get('country');
			$survey->question_1				=	Input::get('question_1');
			$survey->question_2				=	Input::get('question_2');
			$survey->question_3				=	Input::get('question_3');
			$survey->question_4				=	Input::get('question_4');
			$survey->question_5				=	Input::get('question_5');
			$survey->question_6				=	Input::get('question_6');
			$survey->question_7				=	Input::get('question_7');
			$survey->question_8				=	Input::get('question_8');
			$survey->question_9				=	Input::get('question_9');
			$survey->question_10			=	Input::get('question_10');
			$survey->survey_type			=   'customer';

			if($survey->save()) {
				return Redirect::back()->with('message', 'You have successfully completed the survey');
			} else {
				return Redirect::back()->with('message', 'Something went wrong. Please try again');
			}
		}
	} else {
		App::abort(404);
	}
}

public function getCustomerSurveyResults() {

	$ms = Mscustomer::where('user_id', Auth::user()->id)->first();
	if($ms) {
		$surveys = Mscustomersurvey::where('customer_number', $ms->customer_number)->get();
		return View::make('ms.customer.surveys')->with('ms', $ms)->with('surveys', $surveys);
	} else {
		App::abort(404);
	}

}


}
