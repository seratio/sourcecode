<?php

class SubscribeController extends \BaseController {

	/**
	* Display a listing of the resource.
	*
	* @return Response
	*/
	public function index()
	{
		if (Auth::user()->has_role('admin')){
			$subscribes = Subscribe::all();
			return View::make('subscribe.index')
			->with('subscribes', $subscribes);
		}

	}


	/**
	* Show the form for creating a new resource.
	*
	* @return Response
	*/
	public function create()
	{

	}

	public function postAction() {
		if(Input::get('subscribe')) {
			$this->store();
			return Redirect::route('home.index');
		} elseif(Input::get('unsubscribe')) {
			//dd(Input::all());
			$email = Input::get('email');
			$subscriber = Subscribe::where('email', $email)->first();
			if($subscriber){
				$this->destroy($subscriber->id);
				return Redirect::route('home.index');
			} else {
				return Redirect::route('home.index')
				->with('message', 'Email is not in our list');
			}
		} else {
			return Redirect::route('home.index')
			->with('message', 'Unknown request');
		}
	}

	/**
	* Store a newly created resource in storage.
	*
	* @return Response
	*/
	public function store()
	{

		$email     		= Input::get('email');
		$Validator 		= Validator::make(
			array('email'			=> $email),
			array('email'			=>	'required|email|unique:subscribes'));

			if($Validator->fails()){

				return Redirect::route('home.index')
				->withErrors($Validator);
			} else {

				$subscribe 					= 	new Subscribe;
				$subscribe->email 			= 	$email;
				$subscribe->phone           = 	Input::get('phone') ? Input::get('phone') : null;

				if ($subscribe->save()) {
					return Redirect::route('home.index')
					->with('message', 'You have successfully Subscribed!!!');
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
			$subscriber = Subscribe::find($id);
			if ($subscriber->delete()){

				return Redirect::back()
				->with('message', 'You have unsubscribed successfully');
			} else {
				return Redirect::route('users.index')
				->with('error', 'An error occurred.');
			}
		}


	}
