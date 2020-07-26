<?php

class ApiController extends \BaseController {

	public function entry() {
		$cmd = camel_case('cmd_' . Input::get('cmd', ''));
		Log::info(Input::get('cmd') . " from " . Request::getClientIp(), Input::except('password'));
		try {
			// checkUser will throw an ApiException
			// If the user isn't authenticated/is invalid
			// The code will be F1
			$this->checkUser();
		} catch (ApiException $e) {
			return $this->presentError($e->getMessage());
		}
		if (method_exists($this, $cmd)) {
			return call_user_func(array($this, $cmd));
		} else {
            if ($cmd == 'cmd')
                return $this->presentError('F2');
			return $this->presentError('F3');
		}
	}


	public function cmdget() {
		$user = Auth::user();
		try {
			$pv = Blockchain::where('email', Input::get('email'))->first();
			if($pv){
				return Response::json(array('data' => $pv,'status' => 'success'));
			} else {
				return Response::json(array('status' => 'failed', 'message' => 'Not Found'));
			}
		} catch (ApiException $e){
			return $this->presentError($e->getMessage());
		}
	}

	 public function cmdstore()
	 {
		$user = Auth::user();
	 	//dd(Input::all());
		try {
			 	$rules = array(
					'email'							=>	'required|email',
					'family'						=>	'required|numeric',
			 		'worth'							=> 	'required|numeric',
			 		'carbon_reduction'	=> 	'required',
			 		'csr'								=> 	'required|numeric',
			 		'people'						=> 	'required|numeric',
			 		'money_leveraged' 	=> 	'required|numeric',
			 		'currency'					=> 	'required',
			 		);

				$validator = Validator::make(Input::all(), $rules);

		 		if($validator->fails()) {
		 			return Response::json($validator->messages(), 500);

			 	} else {

			 		$country = Input::get('currency') ? Input::get('currency') : null;

			 		if($country!= null){
			 			$country = substr($country, 0,3);
			 		} else {
			 			$country = null;
			 		}

			 		$rate = Currency::convert($country);

					if(!$rate || $rate == 0 || $rate==null){
						return Response::json(array('status' => 'failed', 'message' => 'Invalid Currency'));
					}
			 		$deg_of_seperation 		= 0;
			 		$shares 				= 0.000001;
			 		$carbon_offset 			= 0;
			 		$value_toCO2_non_traded = 54;
			 		$value_toCo2_traded 	= 23;

			 		//getting initial values
			 		$family = Input::get('family') ? Input::get('family') : 0;
			 		$worth = Input::get('worth') ? Input::get('worth') : 0;

			 		$carbon_reduction = Input::get('carbon_reduction') ? Input::get('carbon_reduction') : null;
			 		$country_number = substr(Input::get('currency'), 3, 4);


			 		$data = Environment::find($country_number);


			 		if($data && $carbon_reduction!=null) {
			 			$carbon_reduction = $data->carbon_reduction;
			 		} else{
			 			$carbon_reduction = 1;
			 		}

			 		$csr 							= Input::get('csr') ? Input::get('csr') : 0;
			 		$people 					= Input::get('people') ? Input::get('people') : 0;
			 		$money_leveraged 	= Input::get('money_leveraged') ? Input::get('money_leveraged') : 0;


			 		if($family > 0) {
			 			$family = (($family-($family*20)/100) + ($family+($family*20)/100))/2;
			 		} else {
			 			$family = 0;
			 		}

			 		if($worth > 0){
			 			$worth = (($worth-($worth*20)/100) + ($worth+($worth*20)/100))/2;
			 		} else {
			 			$worth = 0;
			 		}

			 		if($carbon_reduction > 0){
			 			$carbon_reduction = (($carbon_reduction-($carbon_reduction*20)/100) + ($carbon_reduction+($carbon_reduction*20)/100))/2;
			 		} else{
			 			$carbon_reduction = 0;
			 		}

			 		if($csr > 0) {
			 			$csr = (($csr-($csr*20)/100) + ($csr+($csr*20)/100))/2;
			 		} else {
			 			$csr = 0;
			 		}

			 		if($people > 0) {
			 			$people = (($people-($people*20)/100) + ($people+($people*20)/100))/2;
			 		} else {
			 			$people = 0;
			 		}

			 		if($money_leveraged > 0) {
			 			$money_leveraged = (($money_leveraged-($money_leveraged*20)/100) + ($money_leveraged+($money_leveraged*20)/100))/2;
			 		} else {
			 			$money_leveraged = 0;
			 		}
			 		// calculation starts here

			 		$worth 					= $worth ? ($worth/1000000)*$rate : 0;//value/1000000

			 		$csr 					= $csr ? ($csr/1000000)*$rate : 0; //values/1000000
			 		$people 				= $people ? ($people/1000000) : 0;//value/1000000
			 		$money_leveraged 		= $money_leveraged ? ($money_leveraged/1000000)*$rate : 0 ;//value/1000000


			 		$environmental 			= ($carbon_reduction*$value_toCO2_non_traded)/1000000;

			 		$positive = 5;

			 		if($positive) {

			 			$positive = (float) $positive;

						if(!$csr || $csr == 0 || $csr==null){
							return Response::json(array('status' => 'failed', 'message' => 'CSR cannot be zero. Please try again with proper values'));
						}

			 			$cv = (($environmental+$money_leveraged+$csr)+(($people*$worth)/$shares)*(($positive)/10))/$csr*1;

						$pv = round(log($cv, 2),1);

						$blockchain = Blockchain::where('email', Input::get('email'))->first();

						if($blockchain) {
							$blockchain->email 								= Input::get('email');
				 			$blockchain->family 							= $family;
				 			$blockchain->worth 								= $worth;
				 			$blockchain->carbon_reduction 		= $carbon_reduction;
				 			$blockchain->csr 									= $csr;
				 			$blockchain->people 							= $people;
				 			$blockchain->money_leveraged 			= $money_leveraged;
				 			$blockchain->pv   								= $pv;
				 			$blockchain->country     					= $country;
				 			$blockchain->save();
						} else {
							$blockchain 											=	new Blockchain;
							$blockchain->email 								= Input::get('email');
		 		 			$blockchain->family 							= $family;
		 		 			$blockchain->worth 								= $worth;
		 		 			$blockchain->carbon_reduction 		= $carbon_reduction;
		 		 			$blockchain->csr 									= $csr;
		 		 			$blockchain->people 							= $people;
		 		 			$blockchain->money_leveraged 			= $money_leveraged;
		 		 			$blockchain->pv   								= $pv;
		 		 			$blockchain->country     					= $country;
		 		 			$blockchain->save();
						}

						return Response::json(array('data' => $blockchain,'status' => 'success'));

			 		} else {
						return Response::json(array('status' => 'failed'));
			 		}
			 	}
			} catch (ApiException $e){
				return $this->presentError($e->getMessage());
			}
	 }

	 public function cmdgetSV() {
		 $user = Auth::user();
		 try {
			 $sapi = Sapisv::where('email', Input::get('email'))->first();
			 if($sapi){
				 return Response::json(array('ser' => $sapi->ser,'status' => 'success'));
			 } else {
				 return Response::json(array('status' => 'failed', 'message' => 'Not Found'));
			 }
		 } catch (ApiException $e){
			 return $this->presentError($e->getMessage());
		 }
	 }

		public function cmdstoreSV() {
		 $user = Auth::user();
		 try {
				 $rules = array(
					 'positive'											=> 'required|numeric|min:0',
					 'neutral'											=>	'required|numeric|min:0',
					 'negative'											=>	'required|numeric|min:0',
					 'sentimentDate'								=>	'required|date|date_format:Y-m-d',
					 'targetPopulation'							=> 'required|numeric|min:0',
					 'marginErrors'									=> 'required|numeric|min:0',
					 'nonstatutorySpend'						=>	'required|numeric|min:0',
					 'serviceUsers'									=>	'required|numeric|min:0',
					 'assetValue'										=>	'required|numeric|min:0',
					 'staff'												=>	'required|numeric|min:0',
					 'carbonReduction'							=>	'required|numeric|min:0',
					 'carbonOffset'									=>	'required|numeric|min:0',
					 'people'												=>	'required|numeric|min:0',
					 'moneyLeveraged'								=>	'required|numeric|min:0',
					 'email'												=> 'required|email'
					);

				 $validator = Validator::make(Input::all(), $rules);

				 if($validator->fails()) {
					 return Response::json($validator->messages(), 500);

				 } else {

					$value_of_tCO2 					= 54;
					$positive 							= Input::get('positive');
					$neutral								= Input::get('neutral');
					$negative 							= Input::get('negative');
					$sentiment_date 				= Input::get('sentimentDate');

					$tagetPopulation 				= Input::get('targetPopulation');
					$marginErrors 					= Input::get('marginErrors');
					$nonstatutorySpend			= Input::get('nonstatutorySpend');
					$serviceUsers 					= Input::get('serviceUsers');
					$assetValue 						= Input::get('assetValue');
					$staff 									= Input::get('staff');
					$carbonReduction 				= Input::get('carbonReduction');
					$carbonOffset 					= Input::get('carbonOffset');
					$people									= Input::get('people');
					$moneyLeveraged 				= Input::get('moneyLeveraged');
					$email 									= Input::get('email');


 					$environment_eq = $carbonReduction*$value_of_tCO2/1000000;
 					$people_eq  = $people+($staff/1000000);


 					$enviornmental 					= $environment_eq; //E54
 					$carbon_reduction_t 		= $carbonReduction;
 					$money_leveraged 				= $moneyLeveraged; //E50
 					$reported_CSR 					= $nonstatutorySpend; //E25
 					$people 								= $people_eq; //E48
 					$capitalization 				= $assetValue; //E28
 					$shares 								= $serviceUsers; //E27

 					$total									= ($positive+$negative+$neutral); //E22

					if($total == 0){
						return Response::json(array('status' => 'failed', 'message' => 'Total Sentiment cannot be zero'));
					}

					if($marginErrors == 0){
						return Response::json(array('status' => 'failed', 'message' => 'Margin error cannot be zero'));
					}

					if($shares == 0){
						return Response::json(array('status' => 'failed', 'message' => 'Shares cannot be zero'));
					}

					if($nonstatutorySpend == 0){
							return Response::json(array('status' => 'failed', 'message' => 'Non statuatory spend cannot be zero'));
					}

					if($capitalization == 0){
						return Response::json(array('status' => 'failed', 'message' => 'Net asset value cannot be zero'));
					}

 					$critical_sample_size = 0.680625/(($marginErrors*$marginErrors)/10000);


 					if($total < $critical_sample_size) {
 						$reduced_critical_sentiment_sz = $critical_sample_size/(1+(1.65*1.65*0.5*(1-0.5))/(($marginErrors/100)*($marginErrors/100)*$tagetPopulation));
 						if($total < $reduced_critical_sentiment_sz) {
 							$new_margin_of_erros = sqrt((1.65*1.65)*0.5*(1-0.5)/$total);
 							$new_margin_of_erros = round($new_margin_of_erros*100, 5);
 							$reduced_positive_sentiment = ((($new_margin_of_erros/100)-($marginErrors/100))*$positive);

 							$new_positive_total_sentiment = $positive/$total*(1-(($new_margin_of_erros-$marginErrors)/100));
 							$positive = $new_positive_total_sentiment*$total;
 						}
 					}

 					$deg_of_seperation 			= 0; //E26

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


					$sapi = Sapisv::where('email', Input::get('email'))->first();

					if($sapi) {
						$sapi->positive 						= $positive;
						$sapi->negative 						= $negative;
						$sapi->neutral  						= $neutral;
						$sapi->sentiment_date 			= $sentiment_date;

						$sapi->non_statutory_spend 	= $nonstatutorySpend;
						$sapi->no_of_service_users 	= $serviceUsers;
						$sapi->net_asset_value			= $assetValue;
						$sapi->staff 								= $staff;
						$sapi->carbon_reduction_t  	= $carbonReduction;
						$sapi->carbon_offset				= $carbonOffset;
						$sapi->people 							= $people;
						$sapi->money_leveraged      = $moneyLeveraged;

						$sapi->margin_errors 				= $marginErrors;
						$sapi->target_population    = $tagetPopulation;

						$sapi->ser =round($ser, 6);
						$sapi->social_impact = round($social_impact, 6);
						$sapi->social_impact_asap_cap = round($social_impact_asap_cap, 6);
						$sapi->added_value = round($added_socail_value, 6);
						$sapi->environment = round($environment_perc, 2);
						$sapi->people_r = round($people_perc, 2);
						$sapi->cash = round($cash_perc, 2);

						$sapi->environment_eq = $environment_eq;
						$sapi->people_eq = $people;

						$sapi->cash_gen_invested = $cash_gen_invested;
						$sapi->people_cal = $people_per_cal;
						$sapi->enviornment_cal = $enviornment_cal;

						$sapi->save();

					} else {
						$sapi 											=	new Sapisv;
						$sapi->email 								= Input::get('email');

						$sapi->positive 						= $positive;
						$sapi->negative 						= $negative;
						$sapi->neutral  						= $neutral;
						$sapi->sentiment_date 			= $sentiment_date;

						$sapi->non_statutory_spend 	= $nonstatutorySpend;
						$sapi->no_of_service_users 	= $serviceUsers;
						$sapi->net_asset_value			= $assetValue;
						$sapi->staff 								= $staff;
						$sapi->carbon_reduction_t  	= $carbonReduction;
						$sapi->carbon_offset				= $carbonOffset;
						$sapi->people 							= $people;
						$sapi->money_leveraged      = $moneyLeveraged;

						$sapi->margin_errors 				= $marginErrors;
						$sapi->target_population    = $tagetPopulation;

						$sapi->ser =round($ser, 6);
						$sapi->social_impact = round($social_impact, 6);
						$sapi->social_impact_asap_cap = round($social_impact_asap_cap, 6);
						$sapi->added_value = round($added_socail_value, 6);
						$sapi->environment = round($environment_perc, 2);
						$sapi->people_r = round($people_perc, 2);
						$sapi->cash = round($cash_perc, 2);

						$sapi->environment_eq = $environment_eq;
						$sapi->people_eq = $people;

						$sapi->cash_gen_invested = $cash_gen_invested;
						$sapi->people_cal = $people_per_cal;
						$sapi->enviornment_cal = $enviornment_cal;

						$sapi->save();
					}
				 return Response::json(array('ser' => $sapi->ser,'status' => 'success'));
			 }
		 } catch (ApiException $e){
			 return $this->presentError($e->getMessage());
		 }
	}


	public function cmdgetMS() {
		$user = Auth::user();
		try {
			$sapi = Sapims::where('email', Input::get('email'))->first();
			if($sapi){
				return Response::json(array('ms' => $sapi->result,'status' => 'success'));
			} else {
				return Response::json(array('status' => 'failed', 'message' => 'Not Found'));
			}
		} catch (ApiException $e){
			return $this->presentError($e->getMessage());
		}
	}

	 public function cmdstoreMS() {
		$user = Auth::user();
		// dd(Input::all());
		try {
				$rules = array(
					'financialYear'					=> 'required|numeric|min:0',
					'totalSalary'						=> 'required|numeric|min:0',
					'totalStaff'							=> 'required|numeric|min:0',
					'sentiment'								=> 'required|numeric|min:0',
					'email'										=> 'required|email'
				 );

				$validator = Validator::make(Input::all(), $rules);

				if($validator->fails()) {
					return Response::json($validator->messages(), 500);

				} else {

					$financial_year 	= Input::get('financialYear');
 				 	$total_salary 		= Input::get('totalSalary');
 				 	$total_staff			= Input::get('totalStaff');
 				 	$sentiment 				= Input::get('sentiment');

					if($total_staff == 0){
						return Response::json(array('status' => 'failed', 'message' => 'Total staff cannot be zero'));
					}

 				 	$averageSalary = $total_salary/$total_staff;

 				  if(array_key_exists($financial_year, Modernslavery::$WAGE)){
 					 $minimumWage = Modernslavery::$WAGE[$financial_year];
 				  } else {
						return Response::json(array('status' => 'failed', 'message' => 'Unknown Financial Year'));
 				  }

 				  $result =  ($averageSalary + $averageSalary * ($sentiment-50)/100)/($minimumWage*2040);


					$sapi = Sapims::where('email', Input::get('email'))->first();

					if($sapi){
						$sapi->financial_year = $financial_year;
	 				  $sapi->total_salary = $total_salary;
	 				  $sapi->total_staff = $total_staff;
	 				  $sapi->sentiment = $sentiment;
	 				  $sapi->result = $result;

						$sapi->save();
					} else {
						$sapi = new Sapims();
						$sapi->email 		= Input::get('email');
	 				  $sapi->financial_year = $financial_year;

	 				  $sapi->total_salary = $total_salary;
	 				  $sapi->total_staff = $total_staff;
	 				  $sapi->sentiment = $sentiment;
	 				  $sapi->result = $result;

						$sapi->save();
					}
				return Response::json(array('ms' => $sapi->result,'status' => 'success'));
			}
		} catch (ApiException $e){
			return $this->presentError($e->getMessage());
		}
 }

	public function checkUser() {
	 if (Auth::user()) return true;
		 if (!Auth::once(array(
				 'email' => Input::get('username'),
				 'password' => Input::get('password'),
				 'role_id'	=> 24
			 	))) {
		 			throw new ApiException('F1');
	 		}
			 return true;
 }

 // Presentation logic follows
	 /**
		* @param $code
		* @return \Illuminate\Http\JsonResponse
		*/
	 public function presentError($code) {
			 if ($code == 'F1') {
					 $retCode = 401;
			 } else {
					 $retCode = 400;
			 }
	 Log::warning(Lang::get("errors.{$code}"), Input::except("password"));
			 $results = array('Result' => 'Fail', 'Comment' => Lang::get("errors.{$code}"), 'ResponseCode' => $code);
			 return $this->pickFormat(Input::get('fmt'), $results);
 }

	 /**
		* @param string $code
		* @param array $data [optional]
		* @return \Illuminate\Http\JsonResponse
		*/
	 public function presentSuccess($code, $data = array()) {
	 Log::debug(Lang::get("success.{$code}"), Input::except("password"));
			 $results = array_merge(array('Result' => 'Success', 'Comment' => Lang::get("success.{$code}"), 'ResponseCode' => $code), $data);
			 return $this->pickFormat(Input::get('fmt'), $results);
 }

 public function pickFormat($format, $results) {
			 if ($format == 'xml') {
					 $sxe = new SimpleXMLElement('<root/>');
					 $results = array_flip($results);
					 array_walk_recursive($results, array($sxe, 'addChild'));
					 return Response::make($sxe->asXML())
							 ->header('Content-Type', 'application/xml');
			 }
			 return Response::json($results);
	 }



}
