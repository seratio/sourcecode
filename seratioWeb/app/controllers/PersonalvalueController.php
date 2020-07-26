<?php

class PersonalvalueController extends \BaseController {

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

	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//dd(Input::all());
		$rules = array(
			'question1'			=>	'required|numeric',
			'question2'			=> 	'required|numeric',
			'question3'			=> 	'required',
			'question4'			=> 	'required|numeric',
			'question5'			=> 	'required|numeric',
			'question6' 		=> 	'required|numeric',
			'question7'			=> 	'required',
			'question8'			=>	'required',
			'question9'			=> 	'required',
			'currency'			=> 	'required',
			);

			$messages = array(
							    'required' => 'This field is required.',
							);

		$validator = Validator::make(Input::all(), $rules, $messages);

		if($validator->fails()){
			return Redirect::route('frontend.pv')
			->withInput()
			->withErrors($validator);

		} else {

			$country = Input::get('currency') ? Input::get('currency') : null;

			if($country!= null){
				$country = substr($country, 0,3);
			} else {
				$country = null;
			}

			$rate = Currency::convert($country);

			$deg_of_seperation 		= 0;
			$shares 				= 0.000001;
			$carbon_offset 			= 0;
			$value_toCO2_non_traded = 54;
			$value_toCo2_traded 	= 23;

			//getting initial values
			$question1 = Input::get('question1') ? Input::get('question1') : 0;
			$question2 = Input::get('question2') ? Input::get('question2') : 0;

			$carbon = Input::get('question3') ? Input::get('question3') : null;
			$country_number = substr(Input::get('currency'), 3, 4);

			$data = Environment::find($country_number);

			if($data && $carbon!=null) {
				$question3 = $data->$carbon;
			} else{
				$question3 = 1;
			}

			$question4 = Input::get('question4') ? Input::get('question4') : 0;
			$question5 = Input::get('question5') ? Input::get('question5') : 0;
			$question6 = Input::get('question6') ? Input::get('question6') : 0;
			$question7 = Input::get('question7') ? Input::get('question7') : null;
			$question8 = Input::get('question8') ? Input::get('question8') : null;
			$question9 = Input::get('question9') ? Input::get('question9') : null;

			if($question1 > 0) {
				$question1 = (($question1-($question1*20)/100) + ($question1+($question1*20)/100))/2;
			} else {
				$question1 = 0;
			}

			if($question2 > 0){
				$question2 = (($question2-($question2*20)/100) + ($question2+($question2*20)/100))/2;
			} else {
				$question2 = 0;
			}

			if($question3 > 0){
				$question3 = (($question3-($question3*20)/100) + ($question3+($question3*20)/100))/2;
			} else{
				$question3 = 0;
			}

			if($question4 > 0) {
				$question4 = (($question4-($question4*20)/100) + ($question4+($question4*20)/100))/2;
			} else {
				$question4 = 0;
			}

			if($question5 > 0) {
				$question5 = (($question5-($question5*20)/100) + ($question5+($question5*20)/100))/2;
			} else {
				$question5 = 0;
			}

			if($question6 > 0) {
				$question6 = (($question6-($question6*20)/100) + ($question6+($question6*20)/100))/2;
			} else {
				$question6 = 0;
			}



			// calculation starts here
			$family 				= $question1;
			$worth 					= $question2 ? ($question2/1000000)*$rate : 0;//value/1000000

			$carbon_reduction_t  	= $question3;

			$csr 					= $question4 ? ($question4/1000000)*$rate : 0; //values/1000000
			$people 				= $question5 ? ($question5/1000000) : 0;//value/1000000
			$money_leveraged 		= $question6 ? ($question6/1000000)*$rate : 0 ;//value/1000000
			$question7				= $question7;
			$question8				= $question8;
			$question9				= $question9;

			$environmental 			= ($carbon_reduction_t*$value_toCO2_non_traded)/1000000;

			$positive = 5;

			if($positive) {

				$positive = (float) $positive;

				$cv = (($environmental+$money_leveraged+$csr)+(($people*$worth)/$shares)*(($positive)/10))/$csr*1;
				$pv = round(log($cv, 2),1);

				$temp 				= new Temp;
				$temp->question1 	= $family;
				$temp->question2 	= $worth;
				$temp->question3 	= $carbon_reduction_t;
				$temp->question4 	= $csr;
				$temp->question5 	= $people;
				$temp->question6 	= $money_leveraged;
				$temp->pv   		= $pv;
				$temp->question7 	= $question7;
				$temp->question8	= $question8;
				$temp->question9	= $question9;
				$temp->currency     = $country;


				$temp->save();

				$id = $temp->id;

				return View::make('frontend.newpv')->with('pv', $pv)->with('id', $id);
			} else {
				return Redirect::Back()->with('message', 'There is an unexpected error. Please contact the Support Team');
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
		$pvalue =	Pvalue::find($id);
		$quick_pv = $pvalue;
		$count = $quick_pv->counter ? $quick_pv->counter : 0;
		if (Auth::user()->has_role('individual') && Auth::user()->id == $pvalue->user_id){
			return View::make('dashboard.editpv')
			->with('pvalue', $pvalue)->with('quick_pv', $quick_pv)->with('count', $count);
		} else {
			return Redirect::back()->with('message', "You don't permission to edit the values. Please contact administrator");
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

		$pvalue 		= 	Pvalue::find($id);

		if(Auth::user()->has_role('individual') && Auth::user()->id == $pvalue->user_id ) {

			if ($pvalue) {

				$rules = array(
					'question1'			=>	'required|numeric',
					'question2'			=> 	'required|numeric',
					'question3'			=> 	'required',
					'question4'			=> 	'required|numeric',
					'question5'			=> 	'required|numeric',
					'question6' 		=> 	'required|numeric',
					'question7'			=> 	'required',
					'question8'			=>	'required',
					'question9'			=> 	'required',
					'currency'			=> 	'required',
					);

				$messages = array(
							    'required' => 'This field is required.',
							);

				$validator = Validator::make(Input::all(), $rules, $messages);

				if($validator->fails()){
					return Redirect::route('personalvalue.edit', ['id' => $pvalue->id])
					->withErrors($validator);

				} else {

					$country = Input::get('currency') ? Input::get('currency') : null;

					if($country!= null){
						$country = substr($country, 0,3);
					} else {
						$country = null;
					}

					$rate = Currency::convert($country);

					$deg_of_seperation 		= 0;
					$shares 				= 0.000001;
					$carbon_offset 			= 0;
					$value_toCO2_non_traded = 54;
					$value_toCo2_traded 	= 23;

				//getting initial values
					$question1 = Input::get('question1') ? Input::get('question1') : 0;
					$question2 = Input::get('question2') ? Input::get('question2') : 0;

					$carbon = Input::get('question3') ? Input::get('question3') : null;
					$country_number = substr(Input::get('currency'), 3, 4);

					$data = Environment::find($country_number);

					if($data && $carbon!=null) {
						$question3 = $data->$carbon;
					} else{
						$question3 = 1;
					}

					$question4 = Input::get('question4') ? Input::get('question4') : 0;
					$question5 = Input::get('question5') ? Input::get('question5') : 0;
					$question6 = Input::get('question6') ? Input::get('question6') : 0;
					$question7 = Input::get('question7') ? Input::get('question7') : null;
					$question8 = Input::get('question8') ? Input::get('question8') : null;
					$question9 = Input::get('question9') ? Input::get('question9') : null;

					if($question1 > 0) {
						$question1 = (($question1-($question1*20)/100) + ($question1+($question1*20)/100))/2;
					} else {
						$question1 = 0;
					}

					if($question2 > 0){
						$question2 = (($question2-($question2*20)/100) + ($question2+($question2*20)/100))/2;
					} else {
						$question2 = 0;
					}

					if($question3 > 0){
						$question3 = (($question3-($question3*20)/100) + ($question3+($question3*20)/100))/2;
					} else{
						$question3 = 0;
					}

					if($question4 > 0) {
						$question4 = (($question4-($question4*20)/100) + ($question4+($question4*20)/100))/2;
					} else {
						$question4 = 0;
					}

					if($question5 > 0) {
						$question5 = (($question5-($question5*20)/100) + ($question5+($question5*20)/100))/2;
					} else {
						$question5 = 0;
					}

					if($question6 > 0) {
						$question6 = (($question6-($question6*20)/100) + ($question6+($question6*20)/100))/2;
					} else {
						$question6 = 0;
					}



				// calculation starts here
					$family 				= $question1;
					$worth 					= $question2 ? ($question2/1000000)*$rate : 0;//value/1000000

					$carbon_reduction_t  	= $question3;

					$csr 					= $question4 ? ($question4/1000000)*$rate : 0; //values/1000000
					$people 				= $question5 ? ($question5/1000000) : 0;//value/1000000
					$money_leveraged 		= $question6 ? ($question6/1000000)*$rate : 0 ;//value/1000000
					$question7				= $question7;
					$question8				= $question8;
					$question9				= $question9;

					$environmental 			= ($carbon_reduction_t*$value_toCO2_non_traded)/1000000;

					$positive = 5;

					$avg_pos = Feedback::where('pvalue_id', $pvalue->id)->avg('pv');

					$avg_pos = ($avg_pos/10) ? ($avg_pos/10) : 0;

					if($positive) {

						$positive = (float) $positive;

						$cv = (($environmental+$money_leveraged+$csr)+(($people*$worth)/$shares)*(($positive)/10))/$csr*1;
						$pv1 = round(log($cv, 2),1);
						if($avg_pos>0){
							$avg_cv = (($environmental+$money_leveraged+$csr)+(($people*$worth)/$shares)*(($avg_pos)/10))/$csr*1;
							$pv2 = round(log($avg_cv, 2),1);
							$pv = ($pv1+$pv2)/2;
						} else {
							$pv = $pv1;
						}

						$pvalue->question1 	= $family;
						$pvalue->question2 	= $worth;
						$pvalue->question3 	= $carbon_reduction_t;
						$pvalue->question4 	= $csr;
						$pvalue->question5 	= $people;
						$pvalue->question6 	= $money_leveraged;
						$pvalue->pv   		= $pv ? $pv : null;
						$pvalue->question7 	= $question7;
						$pvalue->question8	= $question8;
						$pvalue->question9	= $question9;
						$pvalue->currency   = $country;

						if (Auth::user()->has_role('individual') && $pvalue->update()) {
							return Redirect::route('dashboard.index')
							->with('message', 'You have successfully updated the values');
						} else {
							return Redirect::route('personalvalue.edit', ['id' =>$pvalue->id])
							->withErrors($validator);
						}
					}
				}

				} else {
					return  Redirect::route('dashboard.index')->with('message', 'An unexpected error occured. Please contact administrator');
				}
			} else {
				return  Redirect::route('dashboard.index')->with('message', 'You dont have permission to edit the values');
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

	public function getPDF() {
		$id = Input::get('id');
		$date = date('Y-m-d H:i:s');
		if($id>0) {
			$quick_pv = Pvalue::find($id);
			if($quick_pv){
				$avg = $quick_pv->pv ? $quick_pv->pv : "N/A";
			}

			$html = '<html><body>'

			. '<table style="table-layout:fixed;width:100%;">'
			.'<tr>'
			.'<td colspan="3" style="text-align: center;height: 200px;"><img src="http://www.seratio.com/assets_backend/images/logo_pv.jpg" height="240" width="450" /><br><a style="font-size:125%" href="www.seratio.com">www.seratio.com</a><br><br><a style="font-size:125%">'.Auth::user()->lastname.', '.Auth::user()->firstname.'</a>
			<br><br><a style="font-size:125%">Your PV '.round($avg,2).'</a><br><br><a style="font-size:125%">'.Auth::user()->created_at.'</td></a>'
			.'</tr>'
			.'<tr>'

			. '</table>'
			. '</body></html>';

			return PDF::load($html, 'A4', 'portrait')->download('pvbadge_'.Auth::user()->firstname);
		}
	}
}
