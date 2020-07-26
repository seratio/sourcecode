<?php

class WmfsSupplierController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
			$contracts = Wmcontractbid::where('user_id', Auth::user()->id)->get();
		  $supplier = Wmsupplier::where('user_id', Auth::user()->id)->first();
		  if($supplier){
		 	 $contracts = Wmcontractbid::where('supplier_id', $supplier->id)->get();

			 $totalByIntitiatives = DB::table('wmfscontractbids')
															->select(DB::raw('contract_id, supplier_id,
																SUM(cash) as cash, SUM(people) as people, SUM(positive) as positive,
																SUM(neutral) as neutral, SUM(negative) as negative, SUM(environment) as environment,
																MAX(hyperlocality) as hyperlocality, SUM(target_population) as target_population,
																MAX(margin_errors) as margin_errors, MAX(no_of_months) as no_of_months'))
															->where('supplier_id', $supplier->id)
															->orderBy('contract_id', 'desc')
															->groupBy('contract_id')
															->get();
 			$totalResults = array();
			//dd($totalByIntitiatives);
 			foreach($totalByIntitiatives as $initiative) {
				$contract = Wmcuscontract::find($initiative->contract_id);

 				if($contract) {
						$financialYear = Wmconsuppl::where('contract_id', $initiative->contract_id)->where('supplier_id', $initiative->supplier_id)->first();
 						if($financialYear) {
 							//return Redirect::back()->with('message', "Sorry, We couldn't find any data belongs to your customer's contract. Please contact admin")->with('error_code', 5);
 							$sv = Wmfs::where('user_id', $contract->user_id)->where('measured_year', $financialYear->financial_year)->orderBy('updated_at', 'desc')->first();

		 					if($sv){
								$tot = $initiative->positive+$initiative->negative+$initiative->neutral;
								$pos = $initiative->positive;
								$neu = $tot-$pos;
								$neg = $initiative->negative;

								$new_margin_of_erros = sqrt((1.65*1.65)*0.5*(1-0.5)/$tot);
								$critical_sample_size = 0.680625/(($initiative->margin_errors*$initiative->margin_errors)/10000);

								if($tot < $critical_sample_size) {
									$reduced_critical_sentiment_sz = $critical_sample_size/(1+(1.65*1.65*0.5*(1-0.5))/(($initiative->margin_errors/100)*($initiative->margin_errors/100)*$initiative->target_population));

									if($tot < $reduced_critical_sentiment_sz) {

										//$new_margin_of_erros = round($new_margin_of_erros*100, 5);
										$reduced_positive_sentiment = ((($new_margin_of_erros)-($initiative->margin_errors/100))*$pos);

										$new_positive_total_sentiment = $pos/$tot*(1-($new_margin_of_erros-($initiative->margin_errors/100)));
										$pos = $new_positive_total_sentiment*$tot;
										$total = $pos+$neg+$neu;
									}
								}

		 						//Calculating new positive, negative and neutral for a supplier (Initial+Customer)
		 						// $n_positive = $pos;
		 						// $n_neutral = $neu;
		 						// $n_negative = $neg;
								// $n_total 		= $tot;
								//dd($pos);
								$n_positive = ($pos*$initiative->people)*1000000;
								$n_neutral = ($neu*$initiative->people)*1000000;
								$n_negative = ($neg*$initiative->people)*1000000;
								$n_total 		= $n_positive+$n_neutral+$n_negative;



		 						$value_of_tCO2 					= 54;

		 						$enviornmental 					= ($initiative->environment+$sv->carbon_reduction_t)*$value_of_tCO2/1000000; //E54
		 						$carbon_reduction_t 		= $initiative->environment+$sv->carbon_reduction_t;

		 						$money_leveraged 				= $sv->money_leveraged; //E50

		 						$reported_CSR 					= ($initiative->cash)+$sv->non_statutory_spend;  //E25

		 						//$people 								= round(((($bid->people+$sv->staff)/(1000000))+$sv->people), 3); //E48
		 						$people 								= ($initiative->people+$sv->people)+($sv->staff/1000000);

		 						$capitalization 				= $sv->net_asset_value; //E28
		 						$shares 								= $sv->no_of_service_users; //E27

		 						// $a_positive = $n_positive+(($sv->people_eq*1000000)*$sv->positive);
		 						// $a_negative = $n_negative+(($sv->people_eq*1000000)*$sv->negative);
		 						// $a_neutral  = $n_neutral+(($sv->people_eq*1000000)*$sv->neutral);
								//dd($sv->people_eq);
								//$cal_positive =($n_positive/$sv->positive)>(1-($initiative->margin_errors/100)) ? $sv->original_postive : $pos;
								//$cal_positive =($pos/$sv->original_postive)>(1-$new_margin_of_erros) ? $sv->original_postive : $sv->positive;
								//$cal_negative =($n_negative/$sv->negative)>(1-($bid->margin_errors/100)) ? $sv->original_negative : $neg;
								//$cal_neutral =($n_neutral/$sv->neutral)>(1-($bid->margin_errors/100)) ? $sv->original_neutral : $neu;
								//dd($cal_positive);
								//updated as per request on 14 oct 2018
								$a_positive = $n_positive+((($sv->people_eq*1000000)+$shares)*$pos);
								$a_negative = $n_negative+((($sv->people_eq*1000000)+$shares)*$sv->negative);
								$a_neutral  = $n_neutral+((($sv->people_eq*1000000)+$shares)*$sv->neutral);

		 						$positive 							= $a_positive; //E19
		 						$total									= ($a_positive+$a_negative+$a_neutral); //E22
		 						$deg_of_seperation 			= 0; //E26


		 						$power = pow(10, $deg_of_seperation);
		 						$ser = ($enviornmental+$money_leveraged+$reported_CSR+($people*$capitalization/($shares/1000000))*$positive/$total)/($reported_CSR*$power);

		 						$cash_gen_invested = $money_leveraged+$reported_CSR;
		 						$people_per_cal = ($people*$capitalization/($shares/1000000))*($positive/$total);


		 						$social_impact = $reported_CSR*$ser;
		 						$added_socail_value = $social_impact-$reported_CSR;

								if($contract->hyperlocality_imp > 0){
									$distance = $initiative->hyperlocality;
									$h = $contract->hyperlocality_imp/100;
									$k = $distance;

									$new_added_social_value = $added_socail_value-($k/40075)*$h*$added_socail_value;
									$added_socail_value = $new_added_social_value;
								}

		 						$intervention_across_all_years = $added_socail_value-$sv->added_value;
		 						$contractLength = $contract->contract_length ? ($contract->contract_length/12) : 1;
		 						$yearlyAddedSocialValue = ($intervention_across_all_years/$contractLength)+$sv->added_value;

		 						$social_impact_asap_cap = ($added_socail_value/$capitalization)*100;

		 						$environment_perc = ($enviornmental/($enviornmental+$people_per_cal+$cash_gen_invested))*100;
		 						$people_perc = ($people_per_cal/($enviornmental+$people_per_cal+$cash_gen_invested))*100;
		 						$cash_perc = ($cash_gen_invested/($enviornmental+$people_per_cal+$cash_gen_invested))*100;

		 						$totalResults[$contract->contract_name]['contract_name'] = $contract->contract_name;
		 						$totalResults[$contract->contract_name]['people'] = sprintf('%f', $initiative->people);
		 						$totalResults[$contract->contract_name]['cash'] = $initiative->cash;
		 						$totalResults[$contract->contract_name]['environment'] = $initiative->environment;
		 						$totalResults[$contract->contract_name]['hyperlocality'] = $initiative->hyperlocality ? $initiative->hyperlocality: 'Unknown';
		 						$totalResults[$contract->contract_name]['intervention_across_all_years'] = $intervention_across_all_years;
		 						$totalResults[$contract->contract_name]['n_positive'] = $n_positive;
		 						$totalResults[$contract->contract_name]['n_negative'] = $n_negative;
		 						$totalResults[$contract->contract_name]['n_neutral'] = $n_neutral;

		 						$totalResults[$contract->contract_name]['a_positive'] = $a_positive;
		 						$totalResults[$contract->contract_name]['a_negative'] = $a_negative;
		 						$totalResults[$contract->contract_name]['a_neutral'] = $a_neutral;

		 						$totalResults[$contract->contract_name]['social_impact'] = $social_impact;
		 						$totalResults[$contract->contract_name]['social_impact_asap_cap'] = $social_impact_asap_cap;

		 					//addedvalue divided by total number into the contract no fo months into the contract -- when customer creates the contract
		 						$totalResults[$contract->contract_name]['added_value'] = $added_socail_value;
		 						$totalResults[$contract->contract_name]['environment_r'] = $environment_perc;
		 						$totalResults[$contract->contract_name]['people_r'] = $people_perc;
		 						$totalResults[$contract->contract_name]['cash_r'] = $cash_perc;

		 						$totalResults[$contract->contract_name]['cash_gen_invested'] = $cash_gen_invested ? $cash_gen_invested :0 ;
		 						$totalResults[$contract->contract_name]['people_cal'] = $people_per_cal;
		 						$totalResults[$contract->contract_name]['enviornment_cal'] = $enviornmental;


		 						$totalResults[$contract->contract_name]['ser'] = $ser;

								$total_sv_created_to_date = ($added_socail_value-$sv->added_value)*1000000;
								$sv_forecast_end_of_contract = ($total_sv_created_to_date*($contract->contract_length/$initiative->no_of_months))/$contract->contract_value;

								$sv_created_to_date_minimum = ($total_sv_created_to_date/(($contract->social_impact_min/100)*($contract->contract_value*1000000)))*100;
								$sv_created_to_date_minimum = $sv_created_to_date_minimum > 0 ? $sv_created_to_date_minimum : 0;

								$sv_created_to_date_target = ($total_sv_created_to_date/(($contract->social_value_target/100)*($contract->contract_value*1000000)))*100;
								$sv_created_to_date_target = $sv_created_to_date_target > 0 ? $sv_created_to_date_target : 0;

								$sv_forecast_end_of_contract_minimum = ((($sv_created_to_date_minimum/100)/$initiative->no_of_months)*$contract->contract_length)*100;
								$sv_forecast_end_of_contract_minimum = $sv_forecast_end_of_contract_minimum > 0 ? $sv_forecast_end_of_contract_minimum : 0;

								$sv_forecast_end_of_contract_target = ((($sv_created_to_date_target/100)/$initiative->no_of_months)*$contract->contract_length)*100;
								$sv_forecast_end_of_contract_target = $sv_forecast_end_of_contract_target > 0 ? $sv_forecast_end_of_contract_target : 0;

								$totalResults[$contract->contract_name]['total_sv_created_to_date'] = $total_sv_created_to_date;
								$totalResults[$contract->contract_name]['sv_forecast_end_of_contract'] = $sv_forecast_end_of_contract;
								$totalResults[$contract->contract_name]['sv_created_to_date_minimum'] = $sv_created_to_date_minimum;
								$totalResults[$contract->contract_name]['sv_created_to_date_target'] = $sv_created_to_date_target;
								$totalResults[$contract->contract_name]['sv_forecast_end_of_contract_minimum'] = $sv_forecast_end_of_contract_minimum;
								$totalResults[$contract->contract_name]['sv_forecast_end_of_contract_target'] = $sv_forecast_end_of_contract_target;

		 					}
						}
					}
 			}

		 	return View::make('wmfs.supplier')
								->with('contracts', $contracts)
								->with('totalResults', $totalResults);
		  } else {
		  	$contracts = [];
		  	Session::flash('message', 'Please complete your general info section in order to view the results');
		  	return View::make('wmfs.supplier')->with('contracts', $contracts);
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

			if (Auth::user()->has_subrole('supplier')) {
				$supplier = Wmsupplier::where('user_id', Auth::user()->id)->first();
				$con = Country::countries();
				if($supplier){
					return View::make('wmfs.supplier.general')
						->with('supplier', $supplier)->with('con', $con);
				} else {
					return View::make('wmfs.supplier.general')
						->with('supplier', null)->with('con', $con);
				}
			} else {
				return Redirect::back();
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

		if((Auth::user()->has_role('CUSWM001') || Auth::user()->has_role('CUSWC002') || Auth::user()->has_role('CUSBN003') || Auth::user()->has_role('CUSEC004') || Auth::user()->has_role('CUSSC005') ||
				Auth::user()->has_role('CUSBS006') || Auth::user()->has_role('CUSCB007') || Auth::user()->has_role('CUSHC008') || Auth::user()->has_role('CUSHC009') ||
				Auth::user()->has_role('CUSWF010') || Auth::user()->has_role('CUSCL011') || Auth::user()->has_role('CUSWU012') || Auth::user()->has_role('CUSWD013') || Auth::user()->has_role('CUSNM014')) && Auth::user()->user_defined && Auth::user()->has_subrole('supplier')) {

			$rules = array(
			'supplier_name'										=> 'required',
			'number_street'										=> 'required',
			'city'												=>	'required',
			'county'											=>	'required',
			'post_code'											=> 'required',
			'country' 											=> 'required',
			'supplier_authorised_individuals'					=> 'required'
			);

			$validator = Validator::make(Input::all(), $rules);

			if($validator->fails()) {
				return Redirect::route('suppliers.create')
					->withErrors($validator)
					->withInput();
			} else {
				$supplier = new Wmsupplier($this->supplierParams());
				if(Auth::check() && $supplier->save()) {
					if(!Auth::user()->has_role('admin')) {
						return Redirect::back()
							->with('message', 'You have successfully updated your info');
					} else {
						return Redirect::back()->withInput()->withErrors($validator);
					}
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
   //exit;
		if((Auth::user()->has_role('CUSWM001') ||  Auth::user()->has_role('CUSWC002') || Auth::user()->has_role('CUSBN003') || Auth::user()->has_role('CUSEC004') || Auth::user()->has_role('CUSSC005') ||
				Auth::user()->has_role('CUSBS006') || Auth::user()->has_role('CUSCB007') || Auth::user()->has_role('CUSHC008') || Auth::user()->has_role('CUSHC009') ||
				Auth::user()->has_role('CUSWF010') || Auth::user()->has_role('CUSCL011') || Auth::user()->has_role('CUSWU012') || Auth::user()->has_role('CUSWD013') || Auth::user()->has_role('CUSNM014')) &&  Auth::user()->has_subrole('supplier')) {
			$contract = Wmcontractbid::where('contract_id', $id)->where('supplier_id', Input::get('supplier_id'))->where('initiative_id', Input::get('initiative_id'))->first();
			$customer_contract = Wmcuscontract::find($id);

			if($customer_contract) {
				$financialYear = Wmconsuppl::where('contract_id', $customer_contract->id)->where('supplier_id', $contract->supplier_id)->first();
				if(!$financialYear) {
					return Redirect::back()->with('message', "Sorry, We couldn't find any data belongs to your customer's contract. Please contact admin")->with('error_code', 5);
				}
				//Customer's data
				$sv = Wmfs::where('user_id', $customer_contract->user_id)->where('measured_year', $financialYear->financial_year)->orderBy('updated_at', 'desc')->first();
				//$sv = Wmfs::where('user_id', $customer_contract->user_id)->orderBy('updated_at', 'desc')->first();
				//(($contract->cash_r*$contract->social_impact)-($sv->cash*$sv->social_impact))
					//dd($sv->cash/100);
				//dd(($sv->cash/100)*$sv->social_impact);
				if($contract && $customer_contract && $sv){

					$total_sv_created_to_date = ($contract->added_value-$sv->added_value)*1000000;
					//$sv_forecast_end_of_contract = (($total_sv_created_to_date*$customer_contract->contract_length)/$contract->no_of_months)/($customer_contract->contract_value*1000000);
					$sv_forecast_end_of_contract = ($total_sv_created_to_date*($customer_contract->contract_length/$contract->no_of_months))/$customer_contract->contract_value;
					// var_dump($contract->no_of_months);
					// exit;
					$sv_created_to_date_minimum = ($total_sv_created_to_date/(($customer_contract->social_impact_min/100)*($customer_contract->contract_value*1000000)))*100;
					$sv_created_to_date_minimum = $sv_created_to_date_minimum > 0 ? $sv_created_to_date_minimum : 0;

					$sv_created_to_date_target = ($total_sv_created_to_date/(($customer_contract->social_value_target/100)*($customer_contract->contract_value*1000000)))*100;
					$sv_created_to_date_target = $sv_created_to_date_target > 0 ? $sv_created_to_date_target : 0;

					$sv_forecast_end_of_contract_minimum = ((($sv_created_to_date_minimum/100)/$contract->no_of_months)*$customer_contract->contract_length)*100;
					$sv_forecast_end_of_contract_minimum = $sv_forecast_end_of_contract_minimum > 0 ? $sv_forecast_end_of_contract_minimum : 0;

					$sv_forecast_end_of_contract_target = ((($sv_created_to_date_target/100)/$contract->no_of_months)*$customer_contract->contract_length)*100;
					$sv_forecast_end_of_contract_target = $sv_forecast_end_of_contract_target > 0 ? $sv_forecast_end_of_contract_target : 0;
					// $sv_forecast_end_of_contract = ($total_sv_created_to_date*($customer_contract->contract_length/$contract->no_of_months))/$customer_contract->contract_value;
					// $sv_created_to_date_minimum = ($total_sv_created_to_date)/($customer_contract->contract_value*($customer_contract->social_impact_min/100));
					// $sv_created_to_date_target = ($total_sv_created_to_date)/($customer_contract->contract_value*($customer_contract->social_value_target/100));
					// $sv_forecast_end_of_contract_minimum = ($total_sv_created_to_date*($customer_contract->contract_length/$contract->no_of_months))/($customer_contract->contract_value*($customer_contract->social_impact_min/100));
					// $sv_forecast_end_of_contract_target = ($total_sv_created_to_date*($customer_contract->contract_length/$contract->no_of_months))/($customer_contract->contract_value*($customer_contract->social_value_target/100));

					return View::make('wmfs.supplier.result')
							->with('contract', $contract)
							->with('customer_contract', $customer_contract)
							->with('sv', $sv)
							->with('total_sv_created_to_date', $total_sv_created_to_date)
							->with('sv_forecast_end_of_contract', $sv_forecast_end_of_contract)
							->with('sv_created_to_date_minimum', $sv_created_to_date_minimum )
							->with('sv_created_to_date_target', $sv_created_to_date_target )
							->with('sv_forecast_end_of_contract_minimum', $sv_forecast_end_of_contract_minimum)
							->with('sv_forecast_end_of_contract_target', $sv_forecast_end_of_contract_target);
				} else {
					return Redirect::back()->with('message', 'Something went wrong. Please contact admin');
				}
			} else {
				return Redirect::back()->with('message', 'Contract not existed');
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

	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		if((Auth::user()->has_role('CUSWM001') ||  Auth::user()->has_role('CUSWC002') || Auth::user()->has_role('CUSBN003') || Auth::user()->has_role('CUSEC004') || Auth::user()->has_role('CUSSC005') ||
				Auth::user()->has_role('CUSBS006') || Auth::user()->has_role('CUSCB007') || Auth::user()->has_role('CUSHC008') || Auth::user()->has_role('CUSHC009') ||
				Auth::user()->has_role('CUSWF010') || Auth::user()->has_role('CUSCL011') || Auth::user()->has_role('CUSWU012') || Auth::user()->has_role('CUSWD013') || Auth::user()->has_role('CUSNM014')) && Auth::user()->user_defined && Auth::user()->has_subrole('supplier')) {

			$rules = array(
			'supplier_name'										=> 'required',
			'number_street'										=> 'required',
			'city'												=>	'required',
			'county'											=>	'required',
			'post_code'											=> 'required',
			'country' 											=> 'required',
			'supplier_authorised_individuals'					=> 'required'
			);

			$validator = Validator::make(Input::all(), $rules);

			if($validator->fails()) {
				return Redirect::route('supplier.create')
					->withErrors($validator)
					->withInput();
			} else {
				$supplier = Wmsupplier::find(Input::get('supplier_id'));
				$updated =  $supplier->update($this->supplierParams());
				if(Auth::check() && $updated) {
					if(!Auth::user()->has_role('admin')) {
						return Redirect::back()
							->with('message', 'You have successfully updated your info');
					} else {
						return Redirect::back()->withInput()->withErrors($validator);
					}
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

		if($id > 0 ){
			$wmfsConBid = Wmcontractbid::find($id);
			if(Auth::user()->has_subrole('supplier') && Auth::user()->id == $wmfsConBid->user_id  && $wmfsConBid->delete()){
				return Redirect::back()
					->with('message', 'You have successfully deleted an initiative');
			} else {
				return Redirect::back()
					->with('message', 'Something went wrong. Please try again');
			}
		} else {
			return Redirect::back()
				->with('message', 'Invalid ID');
		}
	}

	public function getContract() {
		if (Auth::user()->has_role('admin')) {
			$values = Wmconsuppl::all();
			return View::make('wmfs.admin.suppliercontracts')->with('values', $values);
		} else {
			App::abort(404);
		}
	}

	public function assignContract() {
		if (Auth::user()->has_role('admin')){

			$rules = array(
				'contract_id'	=> 'required|unique_with:wmconsuppls, supplier_id',
				'supplier_id'		=> 'required',
				'financial_year' => 'required'
			);

			$validator = Validator::make(Input::all(), $rules);

			if($validator->fails()) {
				return Redirect::back()
					->withErrors($validator)
					->withInput()
					->with('error_code', 5);;
			} else {
				$assign_contract = new Wmconsuppl;
				$assign_contract->contract_id = Input::get('contract_id');
				$assign_contract->supplier_id = Input::get('supplier_id');
				$assign_contract->financial_year = Input::get('financial_year');

				if(Auth::user()->has_role('admin') && $assign_contract->save()) {
					return Redirect::back()->with('succes_code', 5)
						->with('message', 'You have successfully assigned a contract to a supplier');
				} else {
					return Redirect::back()->withInput()->withErrors($validator);
				}
			}

		}
	}

	public function getFinancialYear() {
		$contract_id = $_GET['id'];
		$contract = Wmcuscontract::where('id', $contract_id)->first();
		if($contract) {
			$wmfs = Wmfs::where('user_id', $contract->user_id)->get();
			$wmfsData = [];
			foreach($wmfs as $data) {
				if($data->measured_year){
					$wmfsData[] = [$data->measured_year];
				}
			}
			return json_encode($wmfsData);
		} else {
			$wmfs = [];
			return json_encode($wmfs);
		}
	}

	private function supplierParams() {
		return Input::only(['user_id', 'supplier_name', 'number_street', 'city', 'county', 'post_code', 'country', 'supplier_authorised_individuals']);
	}


}
