<?php

class Wmfscontroller extends \BaseController {

	/**
	* Display a listing of the resource.
	*
	* @return Response
	*/
	public function index()
	{
		//dd(Auth::user()->role_id);
		if(Auth::user()->has_role('admin')){
			$wmfs = Wmfs::all();
			if($wmfs) {
				return View::make('wmfs.customer_entries')
				->with('wmfs', $wmfs);
			} else {
				App::abort(404);
			}
		} elseif((Auth::user()->has_role('CUSWM001') || Auth::user()->has_role('CUSWC002') || Auth::user()->has_role('CUSBN003') || Auth::user()->has_role('CUSEC004') || Auth::user()->has_role('CUSSC005') ||
		Auth::user()->has_role('CUSBS006') || Auth::user()->has_role('CUSCB007') || Auth::user()->has_role('CUSHC008') || Auth::user()->has_role('CUSHC009') ||
		Auth::user()->has_role('CUSWF010') || Auth::user()->has_role('CUSCL011') || Auth::user()->has_role('CUSWU012') || Auth::user()->has_role('CUSWD013') || Auth::user()->has_role('CUSNM014')) &&
		Auth::user()->user_defined && Auth::user()->has_subrole('customer')) {

			//$wmfs = Wmfs::where('user_id', Auth::id())->get();

			$wmfs = Wmfs::where('role_id', Auth::user()->role_id)->get();

			if($wmfs) {
				return View::make('wmfs.customer_entries')
				->with('wmfs', $wmfs);
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

		if(Auth::user()->has_role('admin') || Auth::user()->has_role('CUSWM001') || Auth::user()->has_role('CUSWC002') || Auth::user()->has_role('CUSBN003') || Auth::user()->has_role('CUSEC004') || Auth::user()->has_role('CUSSC005') ||
		Auth::user()->has_role('CUSBS006') || Auth::user()->has_role('CUSCB007') || Auth::user()->has_role('CUSHC008') || Auth::user()->has_role('CUSHC009') ||
		Auth::user()->has_role('CUSWF010') || Auth::user()->has_role('CUSCL011') || Auth::user()->has_role('CUSWU012') || Auth::user()->has_role('CUSWD013') || Auth::user()->has_role('CUSNM014')){

			if (Auth::user()->has_subrole('customer')) {
				return View::make('wmfs.add');
			} elseif(Auth::user()->has_subrole('supplier')) {
				//return View::make('wmfs.supplier.general');
			}

		} else {
			return Redirect::back();
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
			'measured_year'										=> 'required|numeric|unique_with:wmfs, user_id',
			'targeted_audience'									=> 'required',
			'positive'											=> 'required|numeric',
			'neutral'											=>	'required|numeric',
			'negative'											=>	'required|numeric',
			'target_population'							=> 'required|numeric',
			'margin_errors'									=> 'required|numeric',
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
			'role_id'											=> 'required|numeric',
			'save_type'											=> 	'',
		);

		$validator = Validator::make(Input::all(), $rules);

		if($validator->fails()) {
			return Redirect::route('organisation.create')
			->withErrors($validator)
			->withInput();
		} else {
			$wmfs = new Wmfs($this->wmfsParams());
			if(Auth::check() && $wmfs->save()) {

				$wmfs->original_postive = $wmfs->positive;
				$wmfs->original_neutral = $wmfs->neutral;
				$wmfs->original_negative = $wmfs->negative;

				$value_of_tCO2 					= 54;

				$environment_eq = $wmfs->carbon_reduction_t*$value_of_tCO2/1000000;
				$people_eq  = $wmfs->people+($wmfs->staff/1000000);


				$enviornmental 					= $environment_eq; //E54
				$carbon_reduction_t 		= $wmfs->carbon_reduction_t;
				$money_leveraged 				= $wmfs->money_leveraged; //E50
				$reported_CSR 					= $wmfs->non_statutory_spend; //E25
				$people 								= $people_eq; //E48
				$capitalization 				= $wmfs->net_asset_value; //E28
				$shares 								= $wmfs->no_of_service_users; //E27

				$positive 							= $wmfs->positive; //E19
				$total									= ($wmfs->positive+$wmfs->negative+$wmfs->neutral); //E22

				$critical_sample_size = 0.680625/(($wmfs->margin_errors*$wmfs->margin_errors)/10000);


				if($total < $critical_sample_size) {
					$reduced_critical_sentiment_sz = $critical_sample_size/(1+(1.65*1.65*0.5*(1-0.5))/(($wmfs->margin_errors/100)*($wmfs->margin_errors/100)*$wmfs->target_population));
					if($total < $reduced_critical_sentiment_sz) {
						$new_margin_of_erros = sqrt((1.65*1.65)*0.5*(1-0.5)/$total);
						//$new_margin_of_erros = round($new_margin_of_erros*100, 5);
						$new_margin_of_erros = $new_margin_of_erros*100;
						$reduced_positive_sentiment = ((($new_margin_of_erros/100)-($wmfs->margin_errors/100))*$positive);

						$new_positive_total_sentiment = $positive/$total*(1-(($new_margin_of_erros-$wmfs->margin_errors)/100));
						$positive = $new_positive_total_sentiment*$total;
						$total = $positive+$wmfs->negative+$wmfs->neutral;
					}
				}

				$deg_of_seperation 			= 0; //E26

				// $value_of_tCO2 					= 52;
				// $enviornmental 					= 2.62; //E54
				//
				// $carbon_reduction_t 		= 50328;
				// $money_leveraged 				= 28.00; //E50
				// $reported_CSR 					= 63.5; //E25
				// $people 								= 8.573; //E48
				// $capitalization 				= 20100; //E28
				// $shares 								= 12200; //E27
				// $positive 							= 37; //E19
				// $total									= 288; //E22
				// $deg_of_seperation 			= 0; //E26
				//var_dump($people);
				$power = pow(10, $deg_of_seperation);
				$ser = ($enviornmental+$money_leveraged+$reported_CSR+($people*$capitalization/($shares/1000000))*$positive/$total)/($reported_CSR*$power);

				$cash_gen_invested = $money_leveraged+$reported_CSR;
				$people_per_cal = ($people*$capitalization/($shares/1000000))*$positive/$total;

				//exit;
				$enviornment_cal = $carbon_reduction_t*$value_of_tCO2/1000000;

				$social_impact = $reported_CSR*$ser;

				$added_socail_value = $social_impact-$reported_CSR;
				$social_impact_asap_cap = ($added_socail_value/$capitalization)*100;

				$environment_perc = ($enviornment_cal/($enviornment_cal+$people_per_cal+$cash_gen_invested))*100;
				$people_perc = ($people_per_cal/($enviornment_cal+$people_per_cal+$cash_gen_invested))*100;
				$cash_perc = ($cash_gen_invested/($enviornment_cal+$people_per_cal+$cash_gen_invested))*100;

				$wmfs->positive = $positive;
				$wmfs->social_impact = $social_impact;
				$wmfs->social_impact_asap_cap = $social_impact_asap_cap;
				$wmfs->added_value = $added_socail_value;
				$wmfs->environment = $environment_perc;
				$wmfs->people_r = $people_perc;
				$wmfs->cash = $cash_perc;

				$wmfs->environment_eq = $environment_eq;
				$wmfs->people_eq = $people;

				$wmfs->cash_gen_invested = $cash_gen_invested;
				$wmfs->people_cal = $people_per_cal;
				$wmfs->enviornment_cal = $enviornment_cal;

				$wmfs->ser =$ser;

				$wmfs->save();

				// if(!Auth::user()->has_role('admin')){
				// 	$user = ['firstname' => Auth::user()->firstname, 'lastname' => Auth::user()->lastname, 'organisation'=> Auth::user()->organisation, 'email' => Auth::user()->email, 'phone_number' => Auth::user()->phone_number];
				// 	$data = array_merge($this->wmfsParams(), $user);
				// 	Mail::send('emails.admin', $data, function($message)
				// 	{
				// 		$message->to('abhijith0009@gmail.com', 'Abhijith Nair')->to('sajn@socialearningsratio.com', 'Sajin Abdu')
				// 		->subject('New Entry!');
				// 	});
				// }
				return Redirect::route('organisation.index')
				->with('message', 'You have successfully saved data.');
			} else {

				return Redirect::back()->withInput()->withErrors($validator);
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

	}


/**
* Show the form for editing the specified resource.
*
* @param  int  $id
* @return Response
*/

	public function edit($id)
	{
		$wmfs = Wmfs::find($id);

		if(Auth::user()->has_role('admin')){

			return View::make('wmfs.edit')
			->with('wmfs', $wmfs);

		} elseif((Auth::user()->has_role('CUSWM001') || Auth::user()->has_role('CUSWC002') || Auth::user()->has_role('CUSBN003') || Auth::user()->has_role('CUSEC004') || Auth::user()->has_role('CUSSC005') ||
				Auth::user()->has_role('CUSBS006') || Auth::user()->has_role('CUSCB007') || Auth::user()->has_role('CUSHC008') || Auth::user()->has_role('CUSHC009') ||
				Auth::user()->has_role('CUSWF010') || Auth::user()->has_role('CUSCL011') || Auth::user()->has_role('CUSWU012') || Auth::user()->has_role('CUSWD013') || Auth::user()->has_role('CUSNM014')) &&
				Auth::check() && Auth::user()->user_defined) {

			$wmfs = DB::table('wmfs')
							->where('id', $id)
							->where('user_id', Auth::id())
							->first();

			if($wmfs){
				$checkYear = DB::table('wmconsuppls')->where('financial_year', $wmfs->measured_year)->first();
				return View::make('wmfs.edit')->with('wmfs', $wmfs);
				// if(($ser == 0 || $ser == '') && $user_id == Auth::id()) {
				// 	return View::make('wmfs.edit')
				// 	->with('wmfs', $value);
				// } else {
				// 	return Redirect::route('organisation.index')
				// 	->with('message', 'You dont have permission to edit this entry. Please contact administrator');
				// }
			} else {
				return Redirect::back()->with('message', 'Something went wrong. Please contact administrator');
			}

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
			'targeted_audience'									=> 'required',
			'positive'											=> 'required|numeric',
			'neutral'											=>	'required|numeric',
			'negative'											=>	'required|numeric',
			'sentiment_date'									=>	'required',
			'target_population'							=> 'required|numeric',
			'margin_errors'									=> 'required|numeric',
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
			'role_id'											=> 'required|numeric',
			'save_type'											=> 	'',
		);

		$validator = Validator::make(Input::all(), $rules);

		if($validator->fails()) {
			return Redirect::route('organisation.edit')
			->withErrors($validator)
			->withInput();
		} else {

			$wmfs = Wmfs::find($id);
			$wmfsData = array_except($this->wmfsParams(), 'measured_year');
			$updated = $wmfs->update($wmfsData);
			if(Auth::check() && $updated) {

				$value_of_tCO2 					= 54;

				$environment_eq = $wmfs->carbon_reduction_t*$value_of_tCO2/1000000;
				$people_eq  = $wmfs->people+($wmfs->staff/1000000);


				$enviornmental 					= $environment_eq; //E54
				$carbon_reduction_t 		= $wmfs->carbon_reduction_t;
				$money_leveraged 				= $wmfs->money_leveraged; //E50
				$reported_CSR 					= $wmfs->non_statutory_spend; //E25
				$people 								= $people_eq; //E48
				$capitalization 				= $wmfs->net_asset_value; //E28
				$shares 								= $wmfs->no_of_service_users; //E27

				$positive 							= $wmfs->original_postive; //E19
				$total									= ($wmfs->original_postive+$wmfs->negative+$wmfs->neutral); //E22

				$critical_sample_size = 0.680625/(($wmfs->margin_errors*$wmfs->margin_errors)/10000);


				if($total < $critical_sample_size) {
					$reduced_critical_sentiment_sz = $critical_sample_size/(1+(1.65*1.65*0.5*(1-0.5))/(($wmfs->margin_errors/100)*($wmfs->margin_errors/100)*$wmfs->target_population));
					if($total < $reduced_critical_sentiment_sz) {
						$new_margin_of_erros = sqrt((1.65*1.65)*0.5*(1-0.5)/$total);
						$new_margin_of_erros = round($new_margin_of_erros*100, 5);
						$reduced_positive_sentiment = ((($new_margin_of_erros/100)-($wmfs->margin_errors/100))*$positive);

						$new_positive_total_sentiment = $positive/$total*(1-(($new_margin_of_erros-$wmfs->margin_errors)/100));
						$positive = $new_positive_total_sentiment*$total;
					}
				}

				$deg_of_seperation 			= 0; //E26

				// $value_of_tCO2 					= 52;
				// $enviornmental 					= 2.62; //E54
				//
				// $carbon_reduction_t 		= 50328;
				// $money_leveraged 				= 28.00; //E50
				// $reported_CSR 					= 63.5; //E25
				// $people 								= 8.573; //E48
				// $capitalization 				= 20100; //E28
				// $shares 								= 12200; //E27
				// $positive 							= 37; //E19
				// $total									= 288; //E22
				// $deg_of_seperation 			= 0; //E26
				//var_dump($people);
				$power = pow(10, $deg_of_seperation);
				$ser = ($enviornmental+$money_leveraged+$reported_CSR+($people*$capitalization/($shares/1000000))*$positive/$total)/($reported_CSR*$power);

				$cash_gen_invested = $money_leveraged+$reported_CSR;
				$people_per_cal = ($people*$capitalization/($shares/1000000))*$positive/$total;

				//exit;
				$enviornment_cal = $carbon_reduction_t*$value_of_tCO2/1000000;

				$social_impact = $reported_CSR*$ser;

				$added_socail_value = $social_impact-$reported_CSR;
				$social_impact_asap_cap = ($added_socail_value/$capitalization)*100;

				$environment_perc = ($enviornment_cal/($enviornment_cal+$people_per_cal+$cash_gen_invested))*100;
				$people_perc = ($people_per_cal/($enviornment_cal+$people_per_cal+$cash_gen_invested))*100;
				$cash_perc = ($cash_gen_invested/($enviornment_cal+$people_per_cal+$cash_gen_invested))*100;

				$wmfs->positive = $positive;
				$wmfs->social_impact = round($social_impact, 6);
				$wmfs->social_impact_asap_cap = round($social_impact_asap_cap, 6);
				$wmfs->added_value = round($added_socail_value, 6);
				$wmfs->environment = round($environment_perc, 2);
				$wmfs->people_r = round($people_perc, 2);
				$wmfs->cash = round($cash_perc, 2);

				$wmfs->environment_eq = $environment_eq;
				$wmfs->people_eq = $people;

				$wmfs->cash_gen_invested = $cash_gen_invested;
				$wmfs->people_cal = $people_per_cal;
				$wmfs->enviornment_cal = $enviornment_cal;

				$wmfs->ser =round($ser, 6);

				$wmfs->save();

				return Redirect::route('organisation.index', ['wmfs' => $wmfs->id])
					->with('message', 'You have successfully updated data.');
			} else {
					return Redirect::route('organisation.edit', ['wmfs'=>$wmfs->id])->withInput()->withErrors($validator);
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
	$wmfs = Wmfs::find($id);
	if($wmfs && $wmfs->user_id && (Auth::user()->has_role('admin') || Auth::user()->has_subrole('customer'))) {
		$contracts = Wmcuscontract::where('user_id', $wmfs->user_id)->get();
		$contractIDs = array();
		foreach($contracts as $contract){
			$contractIDs[] = $contract->id;
		}

		$assignedContracts = Wmconsuppl::where('financial_year', $wmfs->measured_year)->whereIn('contract_id', $contractIDs)->get();
		if(count($assignedContracts) > 0){
			foreach($assignedContracts as $contract) {
				DB::table('wmcuscontracts')->where('id', $contract->contract_id)->delete();
				DB::table('wmfscontractbids')->where('contract_id', $contract->contract_id)->delete();
			}
		}
		$wmfs->delete();
		return Redirect::route('organisation.index')
			->with('message', 'The record has been deleted');
	} else {
		return Redirect::route('organisation.index')
		->with('message', 'You dont have access to delete this record. Please contact the site admin');
	}
}

private function wmfsParams() {
	return Input::only(['measured_year','targeted_audience','positive', 'neutral', 'negative', 'margin_errors', 'target_population', 'sentiment_date',
	'non_statutory_spend', 'no_of_service_users', 'net_asset_value', 'staff',
	'carbon_reduction_t', 'carbon_offset','people', 'money_leveraged', 'cu_directors_salary',
	'cu_members_salary', 'cu_staff_salary_bill', 'cu_executive_board',
	'cu_total_counc_members', 'cu_total_board_senior_directors',
	'cu_total_staff','py_directors_salary', 'py_members_salary',
	'py_staff_salary_bill', 'py_executive_board','py_total_counc_members',
	'py_total_board_senior_directors', 'py_total_staff',
	'user_id', 'save_type', 'role_id']);
}


public function addResult($id) {

	if(Auth::user()->has_role('admin')) {

		$result = Input::all();
		if(array_key_exists('ser', $result) && array_key_exists('social_impact', $result) && array_key_exists('social_impact_asap_cap', $result) && array_key_exists('added_value', $result) && array_key_exists('environment', $result) && array_key_exists('people_r', $result) && array_key_exists('cash', $result)) {

			$wmfs 							= Wmfs::where('id', $id)->first();
			$wmfs->ser  						= Input::get('ser');
			$wmfs->social_impact 			= Input::get('social_impact');
			$wmfs->social_impact_asap_cap 	= Input::get('social_impact_asap_cap');
			$wmfs->added_value 				= Input::get('added_value');
			$wmfs->environment 				= Input::get('environment');
			$wmfs->people_r 	 			= Input::get('people_r');
			$wmfs->cash 		 			= Input::get('cash');

			if($wmfs->save()) {
				Session::flash('message', 'Result updated successfully');
				$user = User::where('id', $wmfs->user_id)->get();
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

				return Redirect::route('organisation.index');

			} else {
				return Redirect::route('organisation.index')
				->with('message', 'There is a problem. Please try again');
			}
		} else {
			return Redirect::route('organisation.index')
			->with('message', 'There is a problem. Please try again');
		}
	} else {
		return Redirect::route('organisation.index')
		->with('message', 'You dont have permission to do it');
	}
}

public function addQuery($id) {

	if(Auth::user()->has_role('admin')) {
		$result = Input::all();

		if(array_key_exists('query', $result)) {
			$wmfs = Wmfs::where('id', $id)->first();
			$wmfs->query = Input::get('query') ? Input::get('query') : 0;

			if($wmfs->save()) {
				Session::flash('message', 'The status has been changed successfully');
				return Redirect::route('organisation.index');
			} else {
				return Redirect::route('organisation.index')
				->with('message', 'There is a problem. Please try again');
			}
		} else {
			return Redirect::route('organisation.index')
			->with('message', 'There is a problem. Please try again');
		}
	} else {
		App::abort(404);
	}
}

public function viewUsers() {

	if(Auth::user()->has_role('admin')) {
		$users = User::where('role_id', '=', '6')->orwhere('role_id', '=', '10')
		->orwhere('role_id', '=', '11')
		->orwhere('role_id', '=', '12')
		->orwhere('role_id', '=', '13')
		->orwhere('role_id', '=', '14')
		->orwhere('role_id', '=', '15')
		->orwhere('role_id', '=', '16')
		->orwhere('role_id', '=', '17')
		->orwhere('role_id', '=', '18')
		->orwhere('role_id', '=', '19')
		->orwhere('role_id', '=', '20')
		->orwhere('role_id', '=', '21')
		->orwhere('role_id', '=', '22')
		->orWhere('role_id', '=', '23')
		->orderBy('created_at', 'desc')
		->get();

		if($users) {
			return View::make('wmfs.users')->with('users', $users);
		} else {
			App::abort(404);
		}
	} else {
		App::abort(404);
	}
}

public function makeCustomer($id) {


	if($id && Auth::user()->has_role('admin')) {

		$user = User::find($id);

		if(!$user->user_defined) {
			$user->user_defined = true;
			$user->subrole_id = 0;
			$user->save();

			$result = [$user->email, $user->firstname];
			$email = $user->email;
			$firstname = $user->firstname;
			Mail::send('emails.approved', $result, function($message) use($email, $firstname)
			{
				$message->to($email, $firstname)
				->subject('Registration Approved!');
			});

			$comp = new Wmcompliance;
			$comp->user_id = $user->id;
			$comp->save();

			return Redirect::back()->with('message', 'You have successfully approved a user');
		} else {
			return Redirect::back()->with('message', "This user's role is already defined. If you still want to make some changes, Please contact admin");
		}

	} else {
		return Redirect::back()->with('message', 'Somthing went wrong. Please try again');
	}
}

public function makeSupplier($id) {

	if($id && Auth::user()->has_role('admin')) {

		$user = User::find($id);

		if(!$user->user_defined) {
			$user->user_defined = true;
			$user->subrole_id = 1;
			$user->save();

			$result = [$user->email, $user->firstname];
			$email = $user->email;
			$firstname = $user->firstname;
			Mail::send('emails.approved', $result, function($message) use($email, $firstname)
			{
				$message->to($email, $firstname)
				->subject('Registration Approved!');
			});
			return Redirect::back()->with('message', 'You have successfully approved a user');
		} else {
			return Redirect::back()->with('message', "This user's role is already defined. If you still want to make some changes, Please contact admin");
		}

	} else {
		return Redirect::back()->with('message', 'Somthing went wrong. Please try again');
	}
}

public function makeBidder($id) {

	if($id && Auth::user()->has_role('admin')) {

		$user = User::find($id);

		if(!$user->user_defined) {
			$user->user_defined = true;
			$user->subrole_id = 3;
			$user->save();

			$result = [$user->email, $user->firstname];
			$email = $user->email;
			$firstname = $user->firstname;
			Mail::send('emails.approved', $result, function($message) use($email, $firstname)
			{
				$message->to($email, $firstname)
				->subject('Registration Approved!');
			});
			return Redirect::back()->with('message', 'You have successfully approved a user');
		} else {
			return Redirect::back()->with('message', "This user's role is already defined. If you still want to make some changes, Please contact admin");
		}

	} else {
		return Redirect::back()->with('message', 'Somthing went wrong. Please try again');
	}
}


public function getKnowledgeBase($id) {

	if($id>0) {
		$user = User::find($id);
		$user->compl = Input::get('compl') ? Input::get('compl') : $user->compl;
		$user->save();
		return Redirect::back()->with('message', 'You have successfully submitted your response');
	} else {
		return Redirect::back()->with('message', 'Something went wrong, Please try again');
	}
}

public function getCompliance($id) {
	if($id>0) {
		$user = User::find($id);
		$compliance = Wmcompliance::where('user_id', $id)->first();
		return View::make('wmfs.admin.compliance')->with('user', $user)->with('compliance', $compliance);
	} else {
		return Redirect::back()->with('message', "Sorry, We couldn't find the user");
	}
}

public function addCompliance($id) {
	//dd(Input::all());
	if($id>0) {
		$user= User::find($id);
		$compliance = Wmcompliance::where('user_id', $id)->first();

		if($compliance) {

			$compliance->environment 						= Input::get('environment') ? Input::get('environment') : $compliance->environment;
			$compliance->environment_rag	 				= Input::get('environment_rag') ? Input::get('environment_rag') : $compliance->environment_rag;
			$compliance->cash 								= Input::get('cash') ? Input::get('cash') : $compliance->cash;
			$compliance->cash_rag 							= Input::get('cash_rag') ? Input::get('cash_rag') : $compliance->cash_rag;
			$compliance->people 							= Input::get('people') ? Input::get('people') : $compliance->people;
			$compliance->people_rag 						= Input::get('people_rag') ? Input::get('people_rag') : $compliance->people_rag;
			$compliance->tax_avoidance 						= Input::get('tax_avoidance') ? Input::get('tax_avoidance') : $compliance->tax_avoidance;
			$compliance->tax_avoidance_rag 					= Input::get('tax_avoidance_rag') ? Input::get('tax_avoidance_rag') : $compliance->tax_avoidance_rag;
			$compliance->pay_disparity 						= Input::get('pay_disparity') ? Input::get('pay_disparity') : $compliance->pay_disparity;
			$compliance->pay_disparity_rag 					= Input::get('pay_disparity_rag') ? Input::get('pay_disparity_rag') : $compliance->pay_disparity_rag;
			$compliance->personal_value 					= Input::get('personal_value') ? Input::get('personal_value') : $compliance->personal_value;
			$compliance->personal_value_rag 				= Input::get('personal_value_rag') ? Input::get('personal_value_rag') : $compliance->personal_value_rag;
			$compliance->transpareny_in_supply_chain 		= Input::get('transpareny_in_supply_chain') ? Input::get('transpareny_in_supply_chain') : $compliance->transpareny_in_supply_chain;
			$compliance->transpareny_in_supply_chain_rag    = Input::get('transpareny_in_supply_chain_rag') ? Input::get('transpareny_in_supply_chain_rag') : $compliance->transpareny_in_supply_chain_rag;
			$compliance->sentiment 							= Input::get('sentiment') ? Input::get('sentiment') : $compliance->sentiment;
			$compliance->sentiment_rag 						= Input::get('sentiment_rag') ? Input::get('sentiment_rag') : $compliance->sentiment_rag;
			$compliance->hyperlocality 						= Input::get('hyperlocality') ? Input::get('hyperlocality') : $compliance->hyperlocality;
			$compliance->hyperlocality_rag 					= Input::get('hyperlocality_rag') ? Input::get('hyperlocality_rag') : $compliance->hyperlocality_rag;
			$compliance->forward_forecasting 				= Input::get('forward_forecasting') ? Input::get('forward_forecasting') : $compliance->forward_forecasting;
			$compliance->forward_forecasting_rag 			= Input::get('forward_forecasting_rag') ? Input::get('forward_forecasting_rag') : $compliance->forward_forecasting_rag;
			$compliance->time_dependent_monitoring 			= Input::get('time_dependent_monitoring') ? Input::get('time_dependent_monitoring') : $compliance->time_dependent_monitoring;
			$compliance->time_dependent_monitoring_rag 		= Input::get('time_dependent_monitoring_rag') ? Input::get('time_dependent_monitoring_rag') : $compliance->time_dependent_monitoring_rag;
			$compliance->financial_value 					= Input::get('financial_value') ? Input::get('financial_value') : $compliance->financial_value;
			$compliance->financial_value_rag 				= Input::get('financial_value_rag') ? Input::get('financial_value_rag') : $compliance->financial_value_rag;
			$compliance->benchmarking 						= Input::get('benchmarking') ? Input::get('benchmarking') : $compliance->benchmarking;
			$compliance->benchmarking_rag 					= Input::get('benchmarking_rag') ? Input::get('benchmarking_rag') : $compliance->benchmarking_rag;


			$compliance->social_value_act 					= Input::get('social_value_act') ? Input::get('social_value_act') : $compliance->social_value_act;
			$compliance->social_value_act_rag 				= Input::get('social_value_act_rag') ? Input::get('social_value_act_rag') : $compliance->social_value_act_rag;
			$compliance->modern_slavery_act 				= Input::get('modern_slavery_act') ? Input::get('modern_slavery_act') : $compliance->modern_slavery_act;
			$compliance->modern_slavery_act_rag 			= Input::get('modern_slavery_act_rag') ? Input::get('modern_slavery_act_rag') : $compliance->modern_slavery_act_rag;
			$compliance->iso26000 							= Input::get('iso26000') ? Input::get('iso26000') : $compliance->iso26000;
			$compliance->iso26000_rag 						= Input::get('iso26000_rag') ? Input::get('iso26000_rag') : $compliance->iso26000_rag;
			$compliance->gri_4 								= Input::get('gri_4') ? Input::get('gri_4') : $compliance->gri_4;
			$compliance->gri4_rag 							= Input::get('gri4_rag') ? Input::get('gri4_rag') : $compliance->gri4_rag;
			$compliance->iirc 								= Input::get('iirc') ? Input::get('iirc') : $compliance->iirc;
			$compliance->iirc_rag 							= Input::get('iirc_rag') ? Input::get('iirc_rag') : $compliance->iirc_rag;
			$compliance->benefit_coro 						= Input::get('benefit_coro') ? Input::get('benefit_coro') : $compliance->benefit_coro;
			$compliance->benefit_coro_rag 					= Input::get('benefit_coro_rag') ? Input::get('benefit_coro_rag') : $compliance->benefit_coro_rag;
			$compliance->wef 								= Input::get('wef') ? Input::get('wef') : $compliance->wef;
			$compliance->wef_rag 							= Input::get('wef_rag') ? Input::get('wef_rag') : $compliance->wef_rag;
			$compliance->wu_500_csr 						= Input::get('wu_500_csr') ? Input::get('wu_500_csr') : $compliance->wu_500_csr;
			$compliance->wu_500_csr_rag 					= Input::get('wu_500_csr_rag') ? Input::get('wu_500_csr_rag') : $compliance->wu_500_csr_rag;
			$compliance->geces 								= Input::get('geces') ? Input::get('geces') : $compliance->geces;
			$compliance->geces_rag 							= Input::get('geces_rag') ? Input::get('geces_rag') : $compliance->geces_rag;
			$compliance->si 								= Input::get('si') ? Input::get('si') : $compliance->si;
			$compliance->si_rag 							= Input::get('si_rag') ? Input::get('si_rag') : $compliance->si_rag;
			$compliance->litigation_liability 				= Input::get('litigation_liability') ? Input::get('litigation_liability') : $compliance->litigation_liability;
			$compliance->litigation_liability_rag 			= Input::get('litigation_liability_rag') ? Input::get('litigation_liability_rag') : $compliance->litigation_liability_rag;

			$compliance->monthly_reporting 					= Input::get('monthly_reporting') ? Input::get('monthly_reporting') : $compliance->monthly_reporting;
			$compliance->monthly_reporting_rag 				= Input::get('monthly_reporting_rag') ? Input::get('monthly_reporting_rag') : $compliance->monthly_reporting_rag;
			$compliance->independent_arbitration 			= Input::get('independent_arbitration') ? Input::get('independent_arbitration') : $compliance->independent_arbitration;
			$compliance->independent_arbitration_rag 		= Input::get('independent_arbitration_rag') ? Input::get('independent_arbitration_rag') : $compliance->independent_arbitration_rag;
			$compliance->dashboard_provision 				= Input::get('dashboard_provision') ? Input::get('dashboard_provision') : $compliance->dashboard_provision;
			$compliance->dashboard_provision_rag 			= Input::get('dashboard_provision_rag') ? Input::get('dashboard_provision_rag') : $compliance->dashboard_provision_rag;
			$compliance->capacity_development_online 		= Input::get('capacity_development_online') ? Input::get('capacity_development_online') : $compliance->capacity_development_online;
			$compliance->capacity_development_online_rag    = Input::get('capacity_development_online_rag') ? Input::get('capacity_development_online_rag') : $compliance->capacity_development_online_rag;
			$compliance->capacity_development_face 			= Input::get('capacity_development_face') ? Input::get('capacity_development_face') : $compliance->capacity_development_face;
			$compliance->capacity_development_face_rag 		= Input::get('capacity_development_face_rag') ? Input::get('capacity_development_face_rag') : $compliance->capacity_development_face_rag;
			$compliance->capacity_development_written 		= Input::get('capacity_development_written') ? Input::get('capacity_development_written') : $compliance->capacity_development_written;
			$compliance->capacity_development_written_rag 	= Input::get('capacity_development_written_rag') ? Input::get('capacity_development_written_rag') : $compliance->capacity_development_written_rag;
			$compliance->engagement 						= Input::get('engagement') ? Input::get('engagement') : $compliance->engagement;
			$compliance->engagement_rag    					= Input::get('engagement_rag') ? Input::get('engagement_rag') : $compliance->engagement_rag;
			$compliance->solutions 							= Input::get('solutions') ? Input::get('solutions') : $compliance->solutions;
			$compliance->solutions_rag 						= Input::get('solutions_rag') ? Input::get('solutions_rag') : $compliance->solutions_rag;
			$compliance->ideation 							= Input::get('ideation') ? Input::get('ideation') : $compliance->ideation;
			$compliance->ideation_rag 						= Input::get('ideation_rag') ? Input::get('ideation_rag') : $compliance->ideation_rag;

			$compliance->compliance_rag 				    = Input::get('compliance_rag') ? Input::get('compliance_rag') : $compliance->compliance_rag;

			$compliance->save();

			return Redirect::back()->with('message', 'You have successfully saved the details');

		} else {
			App::abort(404);
		}
	} else {
		App::abort(404);
	}
}

}
