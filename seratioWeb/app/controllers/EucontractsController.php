<?php

class EucontractsController extends \BaseController {

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
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$user_id = Input::get('user_id') ? Input::get('user_id') :null;

		$rules = array(
			'question1'			=>	'required',
			'question2'			=> 	'required|numeric',
			'question3'			=> 	'required|numeric',
			'question4'			=> 	'required|numeric',
			'question5'			=> 	'required|numeric',
			'question6' 		=> 	'required|numeric',
			'question7'			=> 	'required|numeric',
			'question8'			=>	'required|numeric'
		);

		$messages = array(
							    'required' => 'This field is required.',
							);

		$validator = Validator::make(Input::all(), $rules, $messages);

		if($validator->fails()) {

			return View::make('frontend.eu')->with('id', $user_id)->withErrors($validator);

		} else {

			$question1 = Input::get('question1') ? Input::get('question1') : null;
			$question2 = Input::get('question2') ? Input::get('question2') : 0;
			$question3 = Input::get('question3') ? Input::get('question3') : 0;
			$question4 = Input::get('question4') ? Input::get('question4') : 0;
			$question5 = Input::get('question5') ? Input::get('question5') : 0;
			$question6 = Input::get('question6') ? Input::get('question6') : 0;
			$question7 = Input::get('question7') ? Input::get('question7') : 0;
			$question8 = Input::get('question8') ? Input::get('question8') : 0;

			// calculation starts here
			$fiware 				= $question1;
			$capitalisation 		= $question2;
			$staff 					= $question3;
			$shares					= $question4;
			$csr					= $question5;
			$people					= $question6;
			$sentiment 				= $question7;
			$environment 			= $question8;


			$eu = new Eu;
			$eu->fiware 			= $fiware ? $fiware : null;
			$eu->capitalisation 	= $capitalisation ? $capitalisation : 0;
			$eu->staff 				= $staff ? $staff : 0;
			$eu->shares 			= $shares ? $shares : 0;
			$eu->csr 				= $csr ? $csr : 0;
			$eu->people				= $people ? $people : 0;
			$eu->sentiment 			= $sentiment ? $sentiment: 0;
			$eu->environment 		= $environment ? $environment : 0;
			$eu->user_id 			= $user_id;

			if ($eu->save()) {
				return View::make('frontend.eusucess')->with('message', 'Success');
			} else {
				return View::make('frontend.eu')->with('id', $user_id)->withErrors($validator)->with('message', 'An unexpected error occured. Please try again');
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
