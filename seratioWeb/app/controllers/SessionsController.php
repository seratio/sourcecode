<?php

class SessionsController extends \BaseController {

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		if (Auth::guest())
		{
			return View::make('session.login');
		}
		return Redirect::route('dashboard.index');
	}

	public function pvLogin()
	{
		if (Auth::guest())
		{
			return View::make('session.signin');
		}
		return Redirect::route('dashboard.index');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = array(
			'email'  	=> 'required|email',
			'password'  => 'required'
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()){
			return Redirect::route('sessions.login')
					->withErrors($validator)
					->withInput(Input::except('password'));
		}

		else {
			$userdata = array(
				'email'  => Input::get('email'),
				'password'  => Input::get('password')
				);

		if (Auth::attempt($userdata)){
			return Redirect::route('dashboard.index')
				->with('message', 'You are successfully logged in');
		}
			return Redirect::route('sessions.login')
				->withInput()->with('error', 'Your username or password was incorrect, Please try again!');
		}
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy()
	{
		Auth::logout();
		return Redirect::route('sessions.login')
			->with('message', 'You have successfully logged out!');	}


}
