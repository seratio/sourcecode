<?php

class FeedbackController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

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

		if(Input::get('options')==1){
			$rules = array(
				'scale'			=>	'required|numeric'
				);
		} elseif(Input::get('options')==2){
			$rules = array(
				'comment'			=>	'required'
				);
		}else {
			return Redirect::route('frontend.feedback', ['token' => Input::get('token')])
			->withInput()
			->withErrors("There is an error. Please try again");
		}

		$validator = Validator::make(Input::all(), $rules);

		if($validator->fails()){
			return Redirect::route('frontend.feedback', ['token' => Input::get('token')])
			->withInput()
			->withErrors("Invalid Input !!");

		} else {
			$deg_of_seperation 		= 0;
			$shares 				= 0.000001;
			$carbon_offset 			= 0;
			$value_toCO2_non_traded = 54;
			$value_toCo2_traded 	= 23;

			$user_id = Encryption::decrypt(Input::get('token'));
			$pvalue = Pvalue::where('user_id', $user_id)->first();
			$counter = $pvalue->counter ? $pvalue->counter : 0;

			$user = User::find($user_id);
			$name = $user->firstname;


			$family 				= $pvalue->question1;
			$worth 					= $pvalue->question2;
			$carbon_reduction_t  	= $pvalue->question3;
			$csr 					= $pvalue->question4;
			$people 				= $pvalue->question5;
			$money_leveraged 		= $pvalue->question6;
			$environmental 			= ($carbon_reduction_t*$value_toCO2_non_traded)/1000000;
			$actual_pv              = $pvalue->pv;

			if(Input::get('options')==1){
				$comment 				= Input::get('scale');
				//$positive				= (float) ($comment/10)*2;
				$positive     			= $comment;
				$cv = (($environmental+$money_leveraged+$csr)+(($people*$worth)/$shares)*(($positive)/10))/$csr*1;
				$pv = round(log($cv, 2),2);
				$pv = ($pv+$actual_pv)/2;

				//Saving feedback
				//PV means Positive Value
				$feedback = New Feedback;
				$feedback->pvalue_id = $pvalue->id;
				$feedback->pv = $positive*10;
				$feedback->save();


			} elseif (Input::get('options')==2) {
				$value		 = Personalvalue::calculate($name, Input::get('comment'));
				$positive  = $value->GetScoreResult;
				$data 		 = simplexml_load_string($positive);
				$positive  = $data->result;

				$positive = (float)$positive+(float)3;
				$positive = ($positive/6)*10;

				$cv = (($environmental+$money_leveraged+$csr)+(($people*$worth)/$shares)*($positive/10))/$csr*1;
				$pv = round(log($cv, 2),2);
				$pv = ($pv+$actual_pv)/2;

				//Saving feedback
				//PV means Positive Value
				$feedback = New Feedback;
				$feedback->pvalue_id = $pvalue->id;
				$feedback->pv = ($positive/10)*100;
				$feedback->save();

			}
			$update = Pvalue::where('user_id', '=', $user_id)->update(array('pv' => $pv, 'counter'=> $counter+1));
			$message = Session::flash('message', 'Thank You for rating '." ".$name);
			$user = User::find($user_id);
			$email = $user->email;
			$name = $user->firstname;
			$data = [];
			Mail::send('emails.feedback',$data, function($message) use($email, $name)
					{
					  	$message->to($email, $name)
	          					->subject('New Feedback');
					});
			return View::make('frontend.thanku')->with('message', $message);
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
		//
	}


}
