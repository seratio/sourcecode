<?php

class MSController extends \BaseController {

	/**
	* Display a listing of the resource.
	*
	* @return Response
	*/
	public function index()
	{
		 if(Auth::user()->has_role('Bidder')) {

			$modernSlavery = Modernslavery::where('user_id', Auth::user()->id)->get();
			return View::make('modernSlavery.bidder.index')->with('modernSlavery', $modernSlavery);

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
		if((Auth::user()->has_role('CUSWM001') || Auth::user()->has_role('CUSWC002') || Auth::user()->has_role('CUSBN003') || Auth::user()->has_role('CUSEC004') || Auth::user()->has_role('CUSSC005') ||
		Auth::user()->has_role('CUSBS006') || Auth::user()->has_role('CUSCB007') || Auth::user()->has_role('CUSHC008') || Auth::user()->has_role('CUSHC009') ||
		Auth::user()->has_role('CUSWF010') || Auth::user()->has_role('CUSCL011') || Auth::user()->has_role('CUSWU012') || Auth::user()->has_role('CUSWD013') || Auth::user()->has_role('CUSNM014')) &&
		Auth::user()->has_subrole('customer')) {

			return View::make('modernSlavery.customer.create');

		} else if(Auth::user()->has_role('Bidder')) {

			return View::make('modernSlavery.bidder.create');

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

		if(((Auth::user()->has_role('CUSWM001') || Auth::user()->has_role('CUSWC002') || Auth::user()->has_role('CUSBN003') || Auth::user()->has_role('CUSEC004') || Auth::user()->has_role('CUSSC005') ||
		Auth::user()->has_role('CUSBS006') || Auth::user()->has_role('CUSCB007') || Auth::user()->has_role('CUSHC008') || Auth::user()->has_role('CUSHC009') ||
		Auth::user()->has_role('CUSWF010') || Auth::user()->has_role('CUSCL011') || Auth::user()->has_role('CUSWU012') || Auth::user()->has_role('CUSWD013') || Auth::user()->has_role('CUSNM014')) &&
		Auth::user()->has_subrole('customer')) || Auth::user()->has_role('Bidder')) {

			$rules = array(
				'financial_year'						=> 'required|numeric',
				'user_id' 							=> 'required',
				'total_salary'						=> 'required|numeric',
				'total_staff'						=> 'required|numeric',
				'sentiment'								=> 'required|numeric',
			);

			$validator = Validator::make(Input::all(), $rules);

				if($validator->fails()) {
					//return $validator->messages()->toJson();
					return Redirect::back()
					->withErrors($validator)
					->withInput();
				} else {

					$financial_year 	= Input::get('financial_year');
					$user_id 				= Input::get('user_id');
					$total_salary 	= Input::get('total_salary');
					$total_staff		= Input::get('total_staff');
					$sentiment 			= Input::get('sentiment');

					$averageSalary = $total_salary/$total_staff;

					if(array_key_exists($financial_year, Modernslavery::$WAGE)){
						$minimumWage = Modernslavery::$WAGE[$financial_year];
					} else {
						return Redirect::Back()->with('message', 'Unknown Financial Year');
					}

					$result =  ($averageSalary + $averageSalary * ($sentiment-50)/100)/($minimumWage*2040);

					$ms = new Modernslavery();
					$ms->financial_year = $financial_year;
					$ms->user_id = $user_id;
					$ms->total_salary = $total_salary;
					$ms->total_staff = $total_staff;
					$ms->sentiment = $sentiment;
					$ms->result = $result;

					if($ms->save()){
						return Redirect::Back()
						 ->with('message', 'You have submitted your data, please click <a href="http://seratio.com/dashboard">here</a> to return to main menu');
					} else {
							return Redirect::Back()->with('message', 'Something went wrong. Please try again');
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
