<?php

class WmfsbiddersController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$contract_id = Input::get('contract_id');
		$contract = Wmcuscontract::find($contract_id);

    $isValidContract = Wmconbidder::where('user_id', Auth::user()->id)->where('contract_id', $contract->id)->first();

		//changing the way of displaying bid initiatives as requested by Olinga/Jo on 06/03/2018
		// if((Auth::user()->has_role('Bidder') || Auth::user()->has_role('admin')) && $contract_id){
    //
		// 	$initiatives = Wmconbiddersbid::where('contract_id', $contract_id)->get();
		// 	return View::make('bidder.bids')->with('initiatives', $initiatives)->with('contract', $contract);
		// } else {
		// 	App::abort(400);
		// }
		if(Auth::user()->has_role('Bidder') && $contract_id && $isValidContract) {
			$initiatives = Wmconbiddersbid::where('contract_id', $contract_id)->where('user_id', Auth::user()->id)->get();

			$totalByIntitiatives = DB::table('wmconbiddersbids')
															->select(DB::raw('initiative, bid_value as bid_value,
																SUM(sv_investment) as sv_investment,
																SUM(cost) as cost, SUM(people) as people, SUM(positive) as positive,
																SUM(neutral) as neutral, SUM(negative) as negative, SUM(environment) as environment,
																MAX(hyperlocality) as hyperlocality, SUM(target_population) as target_population,
																MAX(margin_errors) as margin_errors'))
															->where('contract_id', $contract_id)
															->where('user_id', Auth::user()->id)
															->groupBy('initiative')
															->get();

			$totalResults = array();
			foreach($totalByIntitiatives as $initiative){

				if($contract) {
						$financialYear = Wmconbidder::where('contract_id', $contract->id)->where('user_id', Auth::user()->id)->first();
						if(!$financialYear) {
							return Redirect::back()->with('message', "Sorry, We couldn't find any data belongs to your customer's contract. Please contact admin")->with('error_code', 5);
						}

					$sv = Wmfs::where('user_id', $contract->user_id)->where('measured_year', $financialYear->financial_year)->orderBy('updated_at', 'desc')->first();

					if($sv){
						$tot = $initiative->positive+$initiative->negative+$initiative->neutral;
						$pos = $initiative->positive;
						$neu = $tot-$pos;
						$neg = $initiative->negative;
						// if($initiative->initiative == 'Two'){
						// 	dd($reduced_positive_sentiment);
						// }

						//Critical Sentiment sample size
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
						$n_positive = ($pos*$initiative->people)*1000000;
						$n_neutral = ($neu*$initiative->people)*1000000;
						$n_negative = ($neg*$initiative->people)*1000000;
						$n_total 		= $n_positive+$n_neutral+$n_negative;


						$value_of_tCO2 					= 54;

						$enviornmental 					= ($initiative->environment+$sv->carbon_reduction_t)*$value_of_tCO2/1000000; //E54
						$carbon_reduction_t 		= $initiative->environment+$sv->carbon_reduction_t;

						$money_leveraged 				= $sv->money_leveraged; //E50

						$reported_CSR 					= ($initiative->cost)+$sv->non_statutory_spend;  //E25

						//$people 								= round(((($bid->people+$sv->staff)/(1000000))+$sv->people), 3); //E48
						$people 								= ($initiative->people+$sv->people)+($sv->staff/1000000);

						$capitalization 				= $sv->net_asset_value; //E28
						$shares 								= $sv->no_of_service_users; //E27

						//$cal_positive =($pos/$sv->original_postive)>(1-$new_margin_of_erros) ? $sv->original_postive : $sv->positive;

						//Updated as per the request on 14 Oct 2018
						$a_positive = $n_positive+((($sv->people_eq*1000000)+$shares)*$pos);
						$a_negative = $n_negative+((($sv->people_eq*1000000)+$shares)*$sv->negative);
						$a_neutral  = $n_neutral+((($sv->people_eq*1000000)+$shares)*$sv->neutral);

						// if($initiative->initiative == 'Two'){
						// 	var_dump($a_positive);
						// 	var_dump($a_negative);
						// 	dd($a_neutral);
						// }

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

						// if($initiative->initiative == 'Two'){
						//
						// 	dd($intervention_across_all_years);
						// }
						$contractLength = $contract->contract_length ? ($contract->contract_length/12) : 1;
						$yearlyAddedSocialValue = ($intervention_across_all_years/$contractLength)+$sv->added_value;

						$social_impact_asap_cap = ($added_socail_value/$capitalization)*100;

						$environment_perc = ($enviornmental/($enviornmental+$people_per_cal+$cash_gen_invested))*100;
						$people_perc = ($people_per_cal/($enviornmental+$people_per_cal+$cash_gen_invested))*100;
						$cash_perc = ($cash_gen_invested/($enviornmental+$people_per_cal+$cash_gen_invested))*100;

						$totalResults[$initiative->initiative]['initiative'] = $initiative->initiative;
						$totalResults[$initiative->initiative]['people'] = sprintf('%f', $initiative->people);
						$totalResults[$initiative->initiative]['cost'] = $initiative->cost;
						$totalResults[$initiative->initiative]['environment'] = $initiative->environment;
						$totalResults[$initiative->initiative]['hyperlocality'] = $initiative->hyperlocality;
						$totalResults[$initiative->initiative]['intervention_across_all_years'] = $intervention_across_all_years;
						$totalResults[$initiative->initiative]['n_positive'] = $n_positive;
						$totalResults[$initiative->initiative]['n_negative'] = $n_negative;
						$totalResults[$initiative->initiative]['n_neutral'] = $n_neutral;

						$totalResults[$initiative->initiative]['a_positive'] = $a_positive;
						$totalResults[$initiative->initiative]['a_negative'] = $a_negative;
						$totalResults[$initiative->initiative]['a_neutral'] = $a_neutral;

						$totalResults[$initiative->initiative]['social_impact'] = $social_impact;
						$totalResults[$initiative->initiative]['social_impact_asap_cap'] = $social_impact_asap_cap;

					//addedvalue divided by total number into the contract no fo months into the contract -- when customer creates the contract
						$totalResults[$initiative->initiative]['added_value'] = $added_socail_value;
						$totalResults[$initiative->initiative]['environment_r'] = $environment_perc;
						$totalResults[$initiative->initiative]['people_r'] = $people_perc;
						$totalResults[$initiative->initiative]['cash_r'] = $cash_perc;

						$totalResults[$initiative->initiative]['cash_gen_invested'] = $cash_gen_invested ? $cash_gen_invested :0 ;
						$totalResults[$initiative->initiative]['people_cal'] = $people_per_cal;
						$totalResults[$initiative->initiative]['enviornment_cal'] = $enviornmental;

						$totalResults[$initiative->initiative]['ser'] =$ser;

						//Admin values
						$added_sv_perc  						= (($yearlyAddedSocialValue/$sv->added_value)-1)*100;
						//$added_sv_perc = $sv->added_value+($intervention_across_all_years/$contractLength);
						$added_sv_financial_sum 			= $intervention_across_all_years;

						$sv_percentage_of_target = ($intervention_across_all_years/($initiative->bid_value*$contract->social_value_target))*100;

						$totalResults[$initiative->initiative]['added_sv']  						 = $added_sv_perc;
						$totalResults[$initiative->initiative]['added_sv_financial_sum'] =  $added_sv_financial_sum;
						$totalResults[$initiative->initiative]['sv_percentage_of_target'] 	= $sv_percentage_of_target*100;

					}
				} else {
					return Redirect::back()->with('message', "Sorry, We couldn't find any data belongs to your customer's contract. Please contact admin")->with('error_code', 5);
				}
			}
			//dd($totalResults);
			return View::make('bidder.bids')->with('initiatives', $initiatives)->with('contract', $contract)->with('totalResults', $totalResults);
		} else if(Auth::user()->has_role('admin' && $contract_id)) {
			$initiatives = Wmconbiddersbid::where('contract_id', $contract_id)->get();
			return View::make('bidder.bids')->with('initiatives', $initiatives)->with('contract', $contract);
		} else {
			return Redirect::back()->with('message', "You don't have permission to access this page.")->with('error_code', 5);
		}
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$contract_id = Input::get('contract_id');
		$contract = Wmcuscontract::find($contract_id);
		$isValidContract = Wmconbidder::where('user_id', Auth::user()->id)->where('contract_id', $contract->id)->first();

		if($contract_id && $isValidContract && Auth::user()->has_role('Bidder')) {
			return View::make('bidder.initiative')->with('contract', $contract);
		} else {
			return Redirect::back()->with('message', "You don't have permssion to bid on this contract.")->with('error_code', 5);
		}
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if(Auth::user()->has_role('Bidder')) {

			$rules = array(
				'user_id'					=> 'required',
				'contract_id' => 'required',
				'bid_value'						=> 'required',
				'sv_investment'					=> 'required',
				'initiative'				=> 'required',
				'cost' 					=> 'required',
				'people'					=> 'required',
				'positive'				=> 'required',
				'neutral'				=> 'required',
				'negative'			=> 'required',
				'environment'		=> 'required',
				'hyperlocality'				=> 'required',
				'margin_errors'					=> 'required',
				'target_population'			=> 'required',
				'hyperlocality'							=> 'required',
				);

			$validator = Validator::make(Input::all(), $rules);

			if($validator->fails()) {
				return Redirect::back()
				->withErrors($validator)
				->withInput()
				->with('error_code', 5);
			} else {

				$bid 											= new Wmconbiddersbid;
				$bid->user_id 						= Input::get('user_id') ? Input::get('user_id') : null;;
				$bid->contract_id 				= Input::get('contract_id') ? Input::get('contract_id') : null;
				$bid->bid_value 					= Input::get('bid_value') ? Input::get('bid_value') : 1;
				$bid->sv_investment 			= Input::get('sv_investment') ? Input::get('sv_investment') : null;
				$bid->initiative 					= Input::get('initiative') ? Input::get('initiative') : null;
				$bid->cost 								= Input::get('cost') ? Input::get('cost') : null;
				$bid->people 							= Input::get('people') ? Input::get('people') : null;
				$bid->positive 						= Input::get('positive') ? Input::get('positive') : null;
				$bid->neutral 						= Input::get('neutral') ? Input::get('neutral') : null;
				$bid->negative 						= Input::get('negative') ? Input::get('negative') : null;
				$bid->environment 				= Input::get('environment') ? Input::get('environment') : null;
				$bid->hyperlocality 			= Input::get('hyperlocality') ? Input::get('hyperlocality') : null;
				$bid->margin_errors 			= Input::get('margin_errors') ? Input::get('margin_errors') : 10;
				$bid->target_population 	= Input::get('target_population') ? Input::get('target_population') : 50;


				$contract = Wmcuscontract::find($bid->contract_id);

				if($contract) {
						$financialYear = Wmconbidder::where('contract_id', $contract->id)->where('user_id', Auth::user()->id)->first();
						if(!$financialYear) {
							return Redirect::back()->with('message', "Sorry, We couldn't find any data belongs to your customer's contract. Please contact admin")->with('error_code', 5);
						}

					$sv = Wmfs::where('user_id', $contract->user_id)->where('measured_year', $financialYear->financial_year)->orderBy('updated_at', 'desc')->first();
					//$sv = Wmfs::where('user_id', $contract->user_id)->orderBy('updated_at', 'desc')->first();

					if($sv){

						$tot = $bid->positive+$bid->negative+$bid->neutral;
						$pos = $bid->positive;
						$neu = $tot-$pos;
						$neg = $bid->negative;

						//Critical Sentiment sample size
						$critical_sample_size = 0.680625/(($bid->margin_errors*$bid->margin_errors)/10000);

						$new_margin_of_erros = sqrt((1.65*1.65)*0.5*(1-0.5)/$tot);
						$new_margin_of_erros = $new_margin_of_erros*100;

						if($tot < $critical_sample_size) {
							$reduced_critical_sentiment_sz = $critical_sample_size/(1+(1.65*1.65*0.5*(1-0.5))/(($bid->margin_errors/100)*($bid->margin_errors/100)*$bid->target_population));
							if($tot < $reduced_critical_sentiment_sz) {

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

						// //Calculating new positive, negative and neutral for a supplier (Initial+Customer)
						// $n_positive = $sv->positive+$bid->positive;
						// $n_total 		= ($sv->positive+$sv->negative+$sv->neutral)+($bid->positive+$bid->negative+$bid->neutral);
						// $n_neutral = $bid->neutral+$sv->neutral;
						// $n_negative = $bid->negative+$sv->negative;


						$value_of_tCO2 					= 54;


						// $environment_eq = $wmfs->carbon_reduction_t*$value_of_tCO2/1000000;
						// $people_eq  = $wmfs->people+$wmfs->staff/1000000;

						$enviornmental 					= ($bid->environment+$sv->carbon_reduction_t)*$value_of_tCO2/1000000; //E54
						$carbon_reduction_t 		= $bid->environment+$sv->carbon_reduction_t;
						$money_leveraged 				= $sv->money_leveraged; //E50

						$reported_CSR 					= ($bid->cost)+$sv->non_statutory_spend;  //E25

						//$people 								= round(((($bid->people+$sv->staff)/(1000000))+$sv->people), 3); //E48
						$people 								= ($bid->people+$sv->people)+($sv->staff/1000000);

						$capitalization 				= $sv->net_asset_value; //E28
						$shares 								= $sv->no_of_service_users; //E27

						$cal_positive =($pos/$sv->original_postive)>(1-($new_margin_of_erros/100)) ? $sv->original_postive : $sv->positive;

						$a_positive = $n_positive+((($sv->people_eq*1000000)+$shares)*$cal_positive);
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

							$distance = $bid->hyperlocality;
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

					//addedvalue divided by total number into the contract no fo months into the contract -- when customer creates the contract
						$bid->added_value = $added_socail_value;
						$bid->environment_r = $environment_perc;
						$bid->people_r = $people_perc;
						$bid->cash_r = $cash_perc;

						$bid->cash_gen_invested = $cash_gen_invested ? $cash_gen_invested :0 ;
						$bid->people_cal = $people_per_cal;
						$bid->enviornment_cal = $enviornmental;

						$bid->ser = $ser;

						//Admin values
						$added_sv_perc  						= (($yearlyAddedSocialValue/$sv->added_value)-1)*100;
						$added_sv_financial_sum 			= $intervention_across_all_years;

						$sv_percentage_of_target = ($intervention_across_all_years/($bid->bid_value*$contract->social_value_target))*100;

						$bid->added_sv  						 = $added_sv_perc;
						$bid->added_sv_financial_sum =  $added_sv_financial_sum;
						$bid->sv_percentage_of_target 	= $sv_percentage_of_target*100;

						if($bid->save()) {
							//Hyperlocality calculation starts here
							//if(($contract->cash_imp == 100 && $contract->people_imp ==100 && $contract->environment_imp == 100) || ($contract->hyperlocality_imp) == 0){

							if(!Auth::user()->has_role('admin')) {

								return Redirect::back()->with('success_code', 1)
									->with('message', 'You have successfully added a bid, click <a href="https://seratio.com/dashboard">here</a>
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
			return Redirect::back()->with('message', "Sorry, You don't have the permission to add a bid")->with('error_code', 5);
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
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$initiative =	Wmconbiddersbid::find($id);
		if ((Auth::user()->has_role('Bidder')) || (Auth::user()->id == $initiative->id )) {
			$contract = Wmcuscontract::find($initiative->contract_id);
				return View::make('bidder.editinitiative')
					->with('initiative', $initiative)->with('contract', $contract);
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
			$bid = Wmconbiddersbid::find($id);
			if(Auth::user()->has_role('Bidder') && Auth::user()->id == $bid->user_id  && $bid->delete()){
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

	public function viewContracts() {
		if (Auth::user()->has_role('admin')) {
			$values = Wmconbidder::all();
			return View::make('bidder.admin.contracts')->with('values', $values);
		} else {
			App::abort(404);
		}
	}

	public function assignContract() {
		if (Auth::user()->has_role('admin')){

			$rules = array(
				'contract_id'	=> 'required',
				'user_id'		=> 'required',
				'financial_year' => 'required'
			);


			$validator = Validator::make(Input::all(), $rules);

			if($validator->fails()) {
				return Redirect::back()
					->withErrors($validator)
					->withInput()
					->with('error_code', 5);;
			} else {
				$assign_contract = new Wmconbidder;
				$assign_contract->contract_id = Input::get('contract_id');
				$assign_contract->user_id = Input::get('user_id');
				$assign_contract->financial_year = Input::get('financial_year');

				if(Auth::user()->has_role('admin') && $assign_contract->save()) {
					return Redirect::back()->with('succes_code', 5)
						->with('message', 'You have successfully assigned a contract to a bidder');
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

	public function deleteAssignedBidder(){
		$id = Input::get('id');
		if($id){
			$assigned_contract = Wmconbidder::find($id);

			if(Auth::user()->has_role('admin') && $assigned_contract->delete()){
				return Redirect::back()
				->with('message', 'The assigned contract has been removed');
			} else {
				return Redirect::back()
				->with('message', 'You dont have access to delete this record. Please contact admin');
			}
		} else {
			return Redirect::back()
				->with('message', 'Sorry, The record is not existed.');
		}
	}

	public function addBid($id) {

	}

	public function updateResult($id) {

		if(Auth::user()->has_role('admin')) {

			$result = Input::all();
			if(array_key_exists('added_sv', $result) && array_key_exists('added_sv_financial_sum', $result) && array_key_exists('sv_percentage_of_target', $result)) {

				$bid 							= Wmconbiddersbid::where('id', $id)->first();
				$bid->added_sv  						= Input::get('added_sv');
				$bid->added_sv_financial_sum 			= Input::get('added_sv_financial_sum');
				$bid->sv_percentage_of_target 	= Input::get('sv_percentage_of_target');

				if($bid->save()) {
					Session::flash('message', 'Result updated successfully');
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

}
