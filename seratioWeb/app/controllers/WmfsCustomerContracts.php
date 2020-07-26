<?php

class WmfsCustomerContracts extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if(Auth::user()->has_role('CUSWM001') || Auth::user()->has_role('CUSWC002') || Auth::user()->has_role('CUSBN003') || Auth::user()->has_role('CUSEC004') || Auth::user()->has_role('CUSSC005') ||
				Auth::user()->has_role('CUSBS006') || Auth::user()->has_role('CUSCB007') || Auth::user()->has_role('CUSHC008') || Auth::user()->has_role('CUSHC009') ||
				Auth::user()->has_role('CUSWF010') || Auth::user()->has_role('CUSCL011') || Auth::user()->has_role('CUSWU012') || Auth::user()->has_role('CUSWD013') || Auth::user()->has_role('CUSNM014')) {

			if(Auth::user()->has_subrole('customer')) {

				$contracts = Wmcuscontract::where('role_id', Auth::user()->role_id)->get();
				$no_of_contracts = $contracts->count();
				//$contracts = Wmcuscontract::where('user_id', Auth::user()->id)->get();
				return View::make('wmfs.customer.index')->with(['contracts' => $contracts,
					'no_of_contracts' => $no_of_contracts]);
			} elseif(Auth::user()->has_subrole('supplier')) {
				//echo "Success";

				//$contracts = Wmcuscontract::all();
				 $supplier = Wmsupplier::where('user_id', Auth::user()->id)->first();

				  if($supplier){
				 	 $contracts = Wmconsuppl::where('supplier_id', $supplier->id)->get();
				 	 $no_of_contracts = $contracts->count();
				 	 return View::make('wmfs.customer.index')->with(['contracts' => $contracts,
				 	 	'no_of_contracts' => $no_of_contracts]);
				  } else {
				  	$contracts = [];
				  	$no_of_contracts = 0;
				  	Session::flash('message', 'You can only see the contracts assigned to you after completing the general information!');
				  	return View::make('wmfs.customer.index')->with(['contracts' => $contracts,
				  		'no_of_contracts' => $no_of_contracts]);
				  }

			} else {
				App::abort(404);
			}

		} elseif(Auth::user()->has_role('admin')) {

			$contracts = Wmcuscontract::all();
			$no_of_contracts = $contracts->count();
			return View::make('wmfs.customer.index')->with(['contracts' => $contracts,
				'no_of_contracts' => $no_of_contracts]);

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
		if(Auth::user()->has_role('admin') ||((Auth::user()->has_role('CUSWM001') || Auth::user()->has_role('CUSWC002') || Auth::user()->has_role('CUSBN003') || Auth::user()->has_role('CUSEC004') || Auth::user()->has_role('CUSSC005') ||
			Auth::user()->has_role('CUSBS006') || Auth::user()->has_role('CUSCB007') || Auth::user()->has_role('CUSHC008') || Auth::user()->has_role('CUSHC009') ||
			Auth::user()->has_role('CUSWF010') || Auth::user()->has_role('CUSCL011') || Auth::user()->has_role('CUSWU012') || Auth::user()->has_role('CUSWD013') || Auth::user()->has_role('CUSNM014')) &&
			Auth::user()->has_subrole('customer'))) {

			return View::make('wmfs.customer.contract');

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
			'public_sector_organisation'		=> 'required',
			'contract_value'					=> 'required|numeric',
			'contract_reference'				=>	'required',
			'date_start'						=>	'required',
			'contract_length'					=> 'required|integer',
			'social_impact_min'					=> 'numeric',
			'social_value_target'				=> 'numeric',

			'cash_target'						=> 'required|numeric',
			'cash_imp'							=> 'required|numeric',
			'people_target'						=> 'required|numeric',
			'people_imp'						=> 'required|numeric',
			'environment_target'				=> 'required|numeric',
			'environment_imp'					=> 'required|numeric',
			'environment_target'				=> 'required|numeric',
			'hyperlocality_target'				=> 'required|numeric',
			'hyperlocality_imp'					=> 'required|numeric',
			'other'								=> 'numeric',
			'other_imp'							=> 'numeric',
			'role_id'							=> 'required|numeric',
			'guidelines' 						=> ''
			);

		$messages = array(
			'required' => 'This field is required or not valid.',
			);


		$validator = Validator::make(Input::all(), $rules);

		if($validator->fails()) {
			return Redirect::route('customer.create')
			->withErrors($validator)
			->withInput();
		} else {

			$data = $this->contractParams();
			$data['date_start'] = date('Y-m-d',strtotime($data['date_start']));
			//$data['end_date'] = date('Y-m-d', strtotime($data['end_date']));
			$contract = new Wmcuscontract($data);
			if(Auth::check() && $contract->save()) {
				if(!Auth::user()->has_role('admin')) {
					return Redirect::route('customer.index');
				} else {
					return Redirect::back()->withInput()->withErrors($validator);
				}
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
		if(Auth::user()->has_role('CUSWM001') || Auth::user()->has_role('CUSWC002') || Auth::user()->has_role('CUSBN003') || Auth::user()->has_role('CUSEC004') || Auth::user()->has_role('CUSSC005') ||
				Auth::user()->has_role('CUSBS006') || Auth::user()->has_role('CUSCB007') || Auth::user()->has_role('CUSHC008') || Auth::user()->has_role('CUSHC009') ||
				Auth::user()->has_role('CUSWF010') || Auth::user()->has_role('CUSCL011') || Auth::user()->has_role('CUSWU012') || Auth::user()->has_role('CUSWD013') || Auth::user()->has_role('CUSNM014')) {

			$contract = Wmcuscontract::find($id);

			if(Auth::user()->has_subrole('supplier')) {
				$supplier = Wmsupplier::where('user_id', Auth::user()->id)->first();

				if($supplier){
					$bid = Wmcontractbid::where('supplier_id', $supplier->id)->where('contract_id', $contract->id)->first();
				} else {
					return Redirect::back()->with('message', 'Please complete your basic details before viewing the contract details');
				}
					return View::make('wmfs.customer.show')->with('contract', $contract)->with('bid', $bid)->with('bids', null);
					/*if($bid) {
					return View::make('wmfs.customer.show')->with('contract', $contract)->with('bid', $bid)->with('bids', null);
				} else {
					return View::make('wmfs.customer.show')->with('contract', $contract)->with('bid', null)->with('bids', null);
				}*/
			} elseif(Auth::user()->has_subrole('customer')) {

				$bids = Wmcontractbid::where('contract_id', $contract->id)->whereNotNull('cash')->get();
				$customer_contract = Wmcuscontract::find($contract->id);

				$count = $bids->count();

				return View::make('wmfs.customer.show')->with('contract', $contract)->with('bid', null)->with('bids', $bids)->with('count', $count);

			} else {
				App::abort(404);
			}

		} elseif(Auth::user()->has_role('admin')) {

			$contract = Wmcuscontract::find($id);

			$bids = Wmcontractbid::where('contract_id', $contract->id)->whereNotNull('cash')->get();

			$count = $bids->count();

			return View::make('wmfs.customer.show')->with('contract', $contract)->with('bid', null)->with('bids', $bids)->with('count', $count);

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
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if($id > 0 ){
			$contract = Wmcuscontract::find($id);

			if(Auth::user()->has_subrole('customer') && Auth::user()->id == $contract->user_id  && $contract->delete()){
				$affected = DB::table('wmfscontractbids')->where('contract_id', '=', $id)->delete();
				return Redirect::back()
					->with('message', 'You have successfully deleted the contract');
			} else {
				return Redirect::back()
					->with('message', 'Something went wrong. Please try again');
			}
		} else {
			return Redirect::back()
				->with('message', 'Invalid ID');
		}
	}

	public function updateResult($id) {

		if(Auth::user()->has_role('admin')) {

			$result = Input::all();

			if(array_key_exists('total_social_value', $result) && array_key_exists('social_value_min_perc', $result) && array_key_exists('social_value_hun_perc', $result) && array_key_exists('social_value_forecast', $result)) {

				$bid 							= Wmcontractbid::where('id', $id)->first();
				$bid->total_social_value  		= Input::get('total_social_value');
				$bid->social_value_min_perc 	= Input::get('social_value_min_perc');
				$bid->social_value_hun_perc 	= Input::get('social_value_hun_perc');
				$bid->social_value_forecast 	= Input::get('social_value_forecast');


				if($bid->save()) {
					Session::flash('message', 'Result updated successfully');
					$user = User::where('id', $bid->user_id)->get();
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

					return Redirect::back();

				} else {
					return Redirect::back()
					->with('message', 'There is a problem. Please try again');
				}
			} else {
				return Redirect::back()
				->with('message', 'There is a problem. Please try again');
			}
		} else {
			return Redirect::back()
			->with('message', 'You dont have permission to do it');
		}
	}


	public function addBid($id) {


		$ev_cash = Input::file('ev_cash');
		$ev_people = Input::file('ev_people');
		$ev_environment = Input::file('ev_environment');
		$ev_hyperlocality = Input::file('ev_hyperlocality');
		$ev_sentiment = Input::file('ev_sentiment');
		$ev_other = Input::file('ev_other');
		if(Auth::user()->has_subrole('supplier')) {

			$rules = array(
				'user_id'					=> 'required',
				'name_of_initiative' => 'required',
				'no_of_months'				=> 'required|integer',
				'cash'						=> 'required',
				'ev_cash'					=> 'required_without_all:ev_cash_url|mimes:txt,pdf,doc,xls,ppt,rtf',
				'ev_cash_url'				=> 'required_without_all:ev_cash|URL',
				'people' 					=> 'required',
				'ev_people'					=> 'required_without_all:ev_people_url|mimes:txt,pdf,doc,xls,ppt,rtf',
				'ev_people_url'				=> 'required_without_all:ev_people|URL',
				'environment'				=> 'required',
				'ev_environment'			=> 'required_without_all:ev_environment_url|mimes:txt,pdf,doc,xls,ppt,rtf',
				'ev_environment_url'		=> 'required_without_all:ev_environment|URL',
				'hyperlocality'				=> 'required|integer',
				'ev_hyperlocality'			=> 'required_without_all:ev_hyperlocality_url|mimes:txt,pdf,doc,xls,ppt,rtf',
				'ev_hyperlocality_url'		=> 'required_without_all:ev_hyperlocality|URL',
				'sentiment'					=> 'required',
				'ev_sentiment'				=> 'required_without_all:ev_sentiment_url|mimes:txt,pdf,doc,xls,ppt,rtf',
				'ev_sentiment_url'			=> 'required_without_all:ev_sentiment|URL',
				'sample_size'						=> 'required',
				'margin_errors'					=> 'required',
				'target_population'			=> 'required',
				'other'						=> '',
				'ev_other'					=> 'mimes:txt,pdf,doc,xls,ppt,rtf',
				'ev_other_url'				=> '',

				);

			$validator = Validator::make(Input::all(), $rules);

			if($validator->fails()) {
				//return $validator->messages()->toJson();
				return Redirect::back()
				->withErrors($validator)
				->withInput()
				->with('error_code', 5);
			} else {

				$supplier_id = Wmsupplier::where('user_id', Auth::user()->id)->first()->id;
				//$bid_data = Wmcontractbid::where('supplier_id', $supplier_id)->where('contract_id', $id)->get();

				$bid = new Wmcontractbid;
				$bid->supplier_id = $supplier_id;
				$bid->contract_id = $id;

				$get_initiative = Wmcontractbid::where('supplier_id', $supplier_id)->where('contract_id', $id)->orderBy('created_at', 'desc')->first();
				if($get_initiative) {
					$initiative_id =  $get_initiative->initiative_id ? $get_initiative->initiative_id : 0;
					$bid->initiative_id = $initiative_id+1;
				} else {
					$bid->initiative_id = 1;
				}

				$bid->user_id 				= Input::get('user_id') ? Input::get('user_id') : null;
				$bid->name_of_initiative = Input::get('name_of_initiative') ? Input::get('name_of_initiative') : null;
				$bid->no_of_months  			= Input::get('no_of_months') > -1 ? Input::get('no_of_months'): null;
				$bid->cash 					= Input::get('cash') > -1 ? Input::get('cash') : null;
				$bid->people 				= Input::get('people') > -1 ? Input::get('people') : null;
				$bid->environment 			= Input::get('environment') > -1 ? Input::get('environment') : null;

				$bid->hyperlocality 		= Input::get('hyperlocality') ? Input::get('hyperlocality') : null;
				$bid->sentiment 			= Input::get('sentiment') > -1 ? Input::get('sentiment') : null;
				$bid->sample_size    = Input::get('sample_size') > -1 ? Input::get('sample_size') : null;
				//Todo create the fields in db
				$bid->margin_errors = Input::get('margin_errors') ? Input::get('margin_errors') : 10;
				$bid->target_population = Input::get('target_population') ? Input::get('target_population') : 50;
				//end
				$bid->other 				= Input::get('other') > -1 ? Input::get('other') : null;

				$bid->ev_cash_url 			= Input::get('ev_cash_url') ? Input::get('ev_cash_url') : null;
				$bid->ev_people_url 		= Input::get('ev_people_url') ? Input::get('ev_people_url') : null;
				$bid->ev_environment_url 	= Input::get('ev_environment_url') ? Input::get('ev_environment_url') : null;
				$bid->ev_hyperlocality_url 	= Input::get('ev_hyperlocality_url') ? Input::get('ev_hyperlocality_url') : null;
				$bid->ev_sentiment_url 		= Input::get('ev_sentiment_url') ? Input::get('ev_sentiment_url') : null;
				$bid->ev_other_url 			= Input::get('ev_other_url') ? Input::get('ev_other_url') : null;


				if($ev_cash){
					$size = $ev_cash->getSize();
					if($size > 1048576 * 10) {
						return Redirect::back()->withInput()->with('message', 'File is too large. File must be less than 10MB in size')->with('error_code', 5);
					} else {
						$path = public_path(). "/uploads/wmfs/".$bid->contract_id."/suppliers/".$bid->supplier_id."/initiatives/".$bid->initiative_id;

						if(!file_exists($path)) {
							mkdir($path, 0777, true);
						}

						if($bid->ev_cash) {
							$existing = public_path()."/".$bid->ev_cash;
							File::delete($existing);
							$bid->ev_cash = null;

						}

						Input::file('ev_cash')->move($path . "/", $ev_cash->getClientOriginalName());
						$bid->ev_cash = "uploads/wmfs/".$bid->contract_id."/suppliers/".$bid->supplier_id."/initiatives/".$bid->initiative_id."/".$ev_cash->getClientOriginalName();

					}
				} else {
					$bid->ev_cash = null;
				}

				if($ev_people) {

					$size = $ev_people->getSize();
					if($size > 1048576 * 10) {
						return Redirect::back()->withInput()->with('message', 'File is too large. File must be less than 10MB in size')->with('error_code', 5);
					} else {
						$path = public_path(). "/uploads/wmfs/".$bid->contract_id."/suppliers/".$bid->supplier_id."/initiatives/".$bid->initiative_id;

						if(!file_exists($path)) {
							mkdir($path, 0777, true);
						}

						if($bid->ev_people) {
							$existing = public_path()."/".$bid->ev_people;
							File::delete($existing);
							$bid->ev_people = null;

						}

						Input::file('ev_people')->move($path . "/", $ev_people->getClientOriginalName());
						$bid->ev_people = "uploads/wmfs/".$bid->contract_id."/suppliers/".$bid->supplier_id."/initiatives/".$bid->initiative_id."/".$ev_people->getClientOriginalName();

					}
				} else {
					$bid->ev_people = null;
				}

				if($ev_environment) {

					$size = $ev_environment->getSize();

					if($size > 1048576 * 10) {
						return Redirect::back()->withInput()->with('message', 'File is too large. File must be less than 10MB in size')->with('error_code', 5);
					} else {
						$path = public_path(). "/uploads/wmfs/".$bid->contract_id."/suppliers/".$bid->supplier_id."/initiatives/".$bid->initiative_id;

						if(!file_exists($path)) {
							mkdir($path, 0777, true);
						}

						if($bid->ev_environment) {
							$existing = public_path()."/".$bid->ev_environment;
							File::delete($existing);
							$bid->ev_environment = null;

						}

						Input::file('ev_environment')->move($path . "/", $ev_environment->getClientOriginalName());
						$bid->ev_environment = "uploads/wmfs/".$bid->contract_id."/suppliers/".$bid->supplier_id."/initiatives/".$bid->initiative_id."/".$ev_environment->getClientOriginalName();

					}
				} else {
					$bid->ev_environment = null;
				}


				if($ev_hyperlocality) {
					$size = $ev_hyperlocality->getSize();
					if($size > 1048576 * 10) {
						return Redirect::back()->withInput()->with('message', 'File is too large. File must be less than 10MB in size')->with('error_code', 5);
					} else {
						$path = public_path(). "/uploads/wmfs/".$bid->contract_id."/suppliers/".$bid->supplier_id."/initiatives/".$bid->initiative_id;

						if(!file_exists($path)) {
							mkdir($path, 0777, true);
						}

						if($bid->ev_hyperlocality) {
							$existing = public_path()."/".$bid->ev_hyperlocality;
							File::delete($existing);
							$bid->ev_hyperlocality = null;

						}

						Input::file('ev_hyperlocality')->move($path . "/", $ev_hyperlocality->getClientOriginalName());
						$bid->ev_hyperlocality = "uploads/wmfs/".$bid->contract_id."/suppliers/".$bid->supplier_id."/initiatives/".$bid->initiative_id."/".$ev_hyperlocality->getClientOriginalName();

					}
				} else {
					$bid->ev_hyperlocality = null;
				}

				if($ev_sentiment) {
					$size = $ev_sentiment->getSize();
					if($size > 1048576 * 10) {
						return Redirect::back()->withInput()->with('message', 'File is too large. File must be less than 10MB in size')->with('error_code', 5);
					} else {
						$path = public_path(). "/uploads/wmfs/".$bid->contract_id."/suppliers/".$bid->supplier_id."/initiatives/".$bid->initiative_id;

						if(!file_exists($path)) {
							mkdir($path, 0777, true);
						}

						if($bid->ev_sentiment) {
							$existing = public_path()."/".$bid->ev_sentiment;
							File::delete($existing);
							$bid->ev_sentiment = null;

						}

						Input::file('ev_sentiment')->move($path . "/", $ev_sentiment->getClientOriginalName());
						$bid->ev_sentiment = "uploads/wmfs/".$bid->contract_id."/suppliers/".$bid->supplier_id."/initiatives/".$bid->initiative_id."/".$ev_sentiment->getClientOriginalName();

					}
				} else {
					$bid->ev_sentiment = null;
				}


				if($ev_other) {
					$size = $ev_other->getSize();
					if($size > 1048576 * 10) {
						return Redirect::back()->withInput()->with('message', 'File is too large. File must be less than 10MB in size')->with('error_code', 5);
					} else {
						$path = public_path(). "/uploads/wmfs/".$bid->contract_id."/suppliers/".$bid->supplier_id."/initiatives/".$bid->initiative_id;

						if(!file_exists($path)) {
							mkdir($path, 0777, true);
						}

						if($bid->ev_other) {
							$existing = public_path()."/".$bid->ev_other;
							File::delete($existing);
							$bid->ev_other = null;

						}

						Input::file('ev_other')->move($path . "/", $ev_other->getClientOriginalName());
						$bid->ev_other = "uploads/wmfs/".$bid->contract_id."/suppliers/".$bid->supplier_id."/initiatives/".$bid->initiative_id."/".$ev_other->getClientOriginalName();

					}
				} else {
					$bid->ev_other = null;
				}

				$contract = Wmcuscontract::find($bid->contract_id);
				if($contract) {
					$financialYear = Wmconsuppl::where('contract_id', $contract->id)->where('supplier_id', $bid->supplier_id)->first();
					if(!$financialYear) {
						return Redirect::back()->with('message', "Sorry, We couldn't find any data belongs to your customer's contract. Please contact admin")->with('error_code', 5);
					}
					//Customer's data
					$sv = Wmfs::where('user_id', $contract->user_id)->where('measured_year', $financialYear->financial_year)->orderBy('updated_at', 'desc')->first();

					if($sv){

							//Converting sentiment figure to positive, negative and neutral
							// Calculations should be done from the sample size, in order to understand positive, neutral and negative
 							//Otherwise will be a percentage figure
							// if($bid->sentiment <= 0){
							// 	$pos = 0;
							// 	$tot = 0;
							// 	$neu = $tot-$pos;
							// 	$neg = 0;
							// } else {
							// 	$pos 	= $bid->sentiment;
							// 	$tot  = 100;
							// 	$neu  = $tot-$pos;
							// 	$neg  = 0;
							// }

							if($bid->sentiment == 0){
								$neu = 1;
								$tot = 1;
								$pos = 0;
							} else {
								$tot = $bid->sample_size;
								$pos = ($tot)*($bid->sentiment/100);
								$neu = $tot-$pos;
							}
							$neg = 0;
							//var_dump($neu);

							//Critical Sentiment sample size
							$critical_sample_size = 0.680625/(($bid->margin_errors*$bid->margin_errors)/10000);

							$new_margin_of_erros = sqrt((1.65*1.65)*0.5*(1-0.5)/$tot);
							$new_margin_of_erros = $new_margin_of_erros*100;

							if($tot < $critical_sample_size) {
								$reduced_critical_sentiment_sz = $critical_sample_size/(1+(1.65*1.65*0.5*(1-0.5))/(($bid->margin_errors/100)*($bid->margin_errors/100)*$bid->target_population));
								if($tot < $reduced_critical_sentiment_sz) {
									//$new_margin_of_erros = round($new_margin_of_erros*100, 5);
									$reduced_positive_sentiment = ((($new_margin_of_erros/100)-($bid->margin_errors/100))*$pos);

									$new_positive_total_sentiment = $pos/$tot*(1-(($new_margin_of_erros-$bid->margin_errors)/100));
									$pos = $new_positive_total_sentiment*$tot;
									$total = $pos+$neg+$neu;
								}
							}

							//Calculating new positive, negative and neutral for a supplier (Initial+Customer)
							$n_positive = ($pos*$bid->people)*1000000;
							$n_neutral = ($neu*$bid->people)*1000000;
							$n_negative = ($neg*$bid->people)*1000000;
							$n_total 		= $n_positive+$n_neutral+$n_negative;

							// var_dump($n_positive);
							// var_dump($n_neutral);
							// var_dump($n_negative);
							// exit;
							$value_of_tCO2 					= 54;

							// $environment_eq = $wmfs->carbon_reduction_t*$value_of_tCO2/1000000;
							// $people_eq  = $wmfs->people+$wmfs->staff/1000000;

							$enviornmental 					= ($bid->environment+$sv->carbon_reduction_t)*$value_of_tCO2/1000000; //E54

							$carbon_reduction_t 		= $bid->environment+$sv->carbon_reduction_t;
							$money_leveraged 				= $sv->money_leveraged; //E50

							$reported_CSR 					= ($bid->cash)+$sv->non_statutory_spend; //E25

							//$people 								= (($bid->people+$sv->staff)/1000000)+$sv->people; //E48
							$people 								= ($bid->people+$sv->people)+($sv->staff/1000000); //E48

							$capitalization 				= $sv->net_asset_value; //E28
							$shares 								= $sv->no_of_service_users; //E27
							// var_dump($pos);
							// dd($sv->original_postive);
							//Todo

							//$cal_positive =($pos/$sv->original_postive)>(1-($new_margin_of_erros/100)) ? $sv->original_postive : $sv->positive;
							//$cal_negative =($n_negative/$sv->negative)>(1-($bid->margin_errors/100)) ? $sv->original_negative : $neg;
							//$cal_neutral =($n_neutral/$sv->neutral)>(1-($bid->margin_errors/100)) ? $sv->original_neutral : $neu;
							//Updated as per request on 14 Oct 2018
							$a_positive = $n_positive+((($sv->people_eq*1000000)+$shares)*$pos);
							$a_negative = $n_negative+((($sv->people_eq*1000000)+$shares)*$sv->negative);
							$a_neutral  = $n_neutral+((($sv->people_eq*1000000)+$shares)*$sv->neutral);

							$positive 							= $a_positive; //E19
							$total									= ($a_positive+$a_negative+$a_neutral); //E22
							$deg_of_seperation 			= 0; //E26

							//Calculating actual positive, negative and neutral of a supplier

							$power = pow(10, $deg_of_seperation);
							$ser = ($enviornmental+$money_leveraged+$reported_CSR+($people*$capitalization/($shares/1000000))*$positive/$total)/($reported_CSR*$power);

							$cash_gen_invested = $money_leveraged+$reported_CSR;
							$people_per_cal = ($people*$capitalization/($shares/1000000))*($positive/$total);

							$social_impact = $reported_CSR*$ser;
							$added_socail_value = $social_impact-$reported_CSR;

							if($contract->hyperlocality_imp > 0){

								$distance = $bid->hyperlocality;
								$h = $contract->hyperlocality_imp/100;
								$k = $distance;

								$new_added_social_value = $added_socail_value-($k/40075)*$h*$added_socail_value;
								$added_socail_value = $new_added_social_value;
							}

							$intervention_across_all_years = $added_socail_value-$sv->added_value;
							// var_dump($intervention_across_all_years);
							// exit;
							$contractLength = $contract->contract_length ? ($contract->contract_length/12) : 1;
							$yearlyAddedSocialValue = ($intervention_across_all_years/$contractLength)+$sv->added_value;

							$social_impact_asap_cap = ($added_socail_value/$capitalization)*100;

							$environment_perc = ($enviornmental/($enviornmental+$people_per_cal+$cash_gen_invested))*100;
							$people_perc = ($people_per_cal/($enviornmental+$people_per_cal+$cash_gen_invested))*100;
							$cash_perc = ($cash_gen_invested/($enviornmental+$people_per_cal+$cash_gen_invested))*100;

							$bid->intervention_across_all_years = $intervention_across_all_years;

							$bid->positive = $pos;
							$bid->negative = $neg;
							$bid->neutral = $neu;

							$bid->n_positive = $n_positive;
							$bid->n_negative = $n_negative;
							$bid->n_neutral = $n_neutral;

							$bid->a_positive = $a_positive;
							$bid->a_negative = $a_negative;
							$bid->a_neutral = $a_neutral;


							$bid->social_impact = $social_impact;
							$bid->social_impact_asap_cap = $social_impact_asap_cap;
							$bid->added_value = $added_socail_value;
							$bid->environment_r = $environment_perc;
							$bid->people_r = $people_perc;
							$bid->cash_r = $cash_perc;

							$bid->cash_gen_invested = $cash_gen_invested ? $cash_gen_invested :0 ;
							$bid->people_cal = $people_per_cal;
							$bid->enviornment_cal = $enviornmental;

							$bid->ser = $ser;


							if($bid->save()) {
								//Hyperlocality calculation starts here
								//if(($contract->cash_imp == 100 && $contract->people_imp ==100 && $contract->environment_imp == 100) || ($contract->hyperlocality_imp) == 0){

									// Do Nothing

								//} else {

									//$postcode1=$bid->hyperlocality;
									// $postcode2=$contract->hyperlocality_target;
									// $result = array();
                  //
									// $url = "http://maps.googleapis.com/maps/api/distancematrix/json?origins=$postcode1&destinations=$postcode2&mode=walking&language=en-EN&sensor=false";
                  //
									// $data = @file_get_contents($url);
                  //
									// $result = json_decode($data, true);
                  //
									// if($result["status"] == "OK") {
                  //
									// 	foreach($result["rows"] as $data) {
									// 		foreach($data as $value) {
									// 			foreach($value as $distance){
									// 				if(isset($distance["distance"])){
									// 				 $m = $distance["distance"]["value"] ? $distance["distance"]["value"] : 0;
									// 				 $km = $m/1000;
									// 				} else {
									// 					$km = 0;
									// 				}
									// 			}
									// 		}
									// 	}
									// } else {
									// 	$km = 0;
									// }

								if(!Auth::user()->has_role('admin')) {

									return Redirect::back()->with('success_code', 1)
										->with('message', 'You have successfully added a bid, click <a href="http://seratio.com/dashboard">here</a>
			                            go back');
								} else {
									return Redirect::back()->withInput()->withErrors($validator);
								}
							} else {
								App::abort(404);
							}
						} else {
							return Redirect::back()->with('message', "Sorry, Something went wrong. Please contact admin")->with('error_code', 5);
						}
				} else {
					return Redirect::back()->with('message', "Sorry, contract doesn't exist")->with('error_code', 5);
				}
			}
		} else {
			App::abort(404);
		}

	}

	private function contractParams() {
		return Input::only(['user_id', 'role_id', 'public_sector_organisation', 'contract_name', 'contract_value',
			'contract_reference', 'date_start', 'contract_length',
			'social_impact_min', 'social_value_target', 'cash_target', 'cash_imp',
			'people_target', 'people_imp', 'environment_target', 'environment_imp', 'hyperlocality_target', 'hyperlocality_imp',
			'other', 'other_imp', 'guidelines']);
	}


}
