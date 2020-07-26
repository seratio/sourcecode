<?php

class UsersController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$users = User::all();
		if (Auth::user()->has_role('admin')){
			return View::make('user.index')
				->with('users', $users);
		}  else {
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
		$current_url 	= URL::full();
		$temp_id  		= Input::get('id') ? Input::get('id') : null;
		$eu_id 			= strpos($current_url, 'eu') ? TRUE : FALSE;
		$ms 			= strpos($current_url, 'ms') ? TRUE : FALSE;
		$pslight 		= strpos($current_url, 'pslight') ? TRUE : FALSE;
		$coun = Country::countries();

		if (Auth::guest() && $temp_id){
			$user = new User;
			return View::make('user.register', ['user' => $user, 'temp_id' => $temp_id, 'eu_id'=> $eu_id, 'ms' => $ms]);
		} elseif (Auth::guest() && $eu_id) {
			$user = new User;
			return View::make('user.register', ['user' => $user, 'temp_id' => $temp_id, 'eu_id' => $eu_id, 'ms' => $ms]);
		} elseif (Auth::guest() && $ms) {
			$user = new User;
			return View::make('user.register', ['user' => $user, 'temp_id' => $temp_id, 'eu_id' => $eu_id, 'ms' => $ms, 'coun' => $coun]);
		} elseif (Auth::guest()) {
			$user = new User;
			return View::make('user.register', ['user' => $user, 'temp_id' => $temp_id, 'eu_id' => $eu_id, 'ms' => $ms]);
		}elseif(Auth::user()->has_role('admin')) {
				$user = new User;
				return View::make('user.adduser',['user' => $user, 'ms' => $ms, 'pslight' => $pslight]);
		} else {
				return Redirect::route('dashboard.index');
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
						'title' 			=>	'',
						'firstname'			=>	'required',
						'lastname'			=>	'required',
						'position'			=> 	'',
						'organisation'		=> 	'',
						'phone_number'		=> 	'',
						'password'			=> 	'required',
						'password_confirmation' => 'same:password',
						'email'				=>	'required|email|unique:users',
						'role_id'			=>	'required',
						'gender'			=> '',
						'postcode'			=> '',
						'country'           => '',
						'subrole_id'		=> ''
					);
		$validator = Validator::make($this->userParams(), $rules);

		if($validator->fails()){
			//return $validator->messages()->toJson();
				return Redirect::back()
					->withInput(Input::except('password'))
					->withErrors($validator);

		} else {
			$user = new User($this->userParams());
			if ($user->save()) {

				if(Input::get('role_id') == 6 || Input::get('role_id') == 10 ||  Input::get('role_id') == 11 ||  Input::get('role_id') == 12 ||  Input::get('role_id') == 13 ||
					 Input::get('role_id') == 14 ||  Input::get('role_id') == 15 ||  Input::get('role_id') == 16 ||  Input::get('role_id') == 17 ||  Input::get('role_id') == 18 ||
					  Input::get('role_id') == 19 ||  Input::get('role_id') == 20 ||  Input::get('role_id') == 21 ||  Input::get('role_id') == 22 ){

					$user->subrole_id = 3;
					$user->user_defined = 0;
					$user->save();

					$data = $this->userParams();

					Mail::send('emails.wmfs_reg', $data, function($message)
					{
					  	$message->to('abhijith.nair@seratio.com', 'Abhijith Nair')->to('sajin.abdu@seratio.com', 'Sajin Abdu')
	          					->subject('New Registration!');
					});
				}
				if ($user->role_id == 23) {
					$user->user_defined = 0;
					$user->subrole_id = 3;
					$user->save();
				}
				if ($user->role_id == 7) {
					return View::make('frontend.eu')->with('id', $user->id)->with('message', 'You have successfully registered. All the information you provided will reamain confidential');
				}

				if ($user->role_id == 8) {
					$mscustomer = new Mscustomer;
					$mscustomer->user_id = $user->id;
					$mscustomer->customer_number = strtoupper(substr(md5(uniqid($user->email, true)), 0, 10));
					$mscustomer->customer_type = Input::get('customer_type') ? Input::get('customer_type') : null;
					$mscustomer->save();
				}

				if ($user->role_id == 9) {
					$microsite = new Microsite;
					$microsite->user_id = $user->id;
					$microsite->customer_type = Input::get('customer_type') ? Input::get('customer_type') : null;
					$microsite->save();

					$microvalue = new Microvalue;
					$microvalue->user_id = $user->id;
					$microvalue->microsite_id = $microsite->id;
					$microvalue->save();
				}

				$temp_id = Input::get('temp_id');
				if($temp_id) {
					$temp = Temp::find($temp_id);
					if($temp) {
						$pvalue 			= new Pvalue;

						$pvalue->user_id 	= $user->id;
						$pvalue->name 		= $temp->name;
						$pvalue->comment 	= $temp->comment;
						$pvalue->question1 	= $temp->question1;
						$pvalue->question2 	= $temp->question2;
						$pvalue->question3 	= $temp->question3;
						$pvalue->question4 	= $temp->question4;
						$pvalue->question5 	= $temp->question5;
						$pvalue->question6 	= $temp->question6;
						$pvalue->pv   		= $temp->pv;
						$pvalue->question7  = $temp->question7;
						$pvalue->question8	= $temp->question8;
						$pvalue->question9	= $temp->question9;
						$pvalue->currency   = $temp->currency;

						$pvalue->save();

						Temp::destroy($temp_id);
					}
				}

				/*$eu_id = Input::get('eu_id');
				if($eu_id) {
					$temp = Temp::find($eu_id);
					if($temp) {
						$eu = new Eu;
						$eu->fiware 			= $temp->fiware;
						$eu->capitalisation 	= $temp->capitalisation;
						$eu->staff 				= $temp->staff;
						$eu->shares 			= $temp->shares;
						$eu->csr 				= $temp->csr;
						$eu->people				= $temp->people;
						$eu->sentiment 			= $temp->sentiment;
						$eu->environment 		= $temp->environment;
						$eu->user_id 			= $user->id;

						$eu->save();

						Temp::destroy($eu_id);
					}
				}*/

				if(Auth::check() && Auth::user()->has_role('admin')) {
					if($user->role_id == 8) {
						return Redirect::route('modernslavery.users')->with('message', 'You have successfully added a customer');
					} else {
						return Redirect::back()->with('message', 'You have successfully added a user');
					}
				} else {
					$userdata = array(
						'email'  => Input::get('email'),
						'password'  => Input::get('password')
					);
					if (Auth::attempt($userdata)){
						return Redirect::route('dashboard.index')
							->with('message', 'You are successfully logged in');
					} else {
					return Redirect::route('sessions.login')
						->with('message', 'You have successfully registered!');
					}
				}

			} else {
				return Redirect::back()
					->withInput(Input::except('password'))
					->withErrors($validator);
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
		if (Auth::user()->has_role('admin')  || Auth::user()->username == $id){
			$user = User::find($id);
			return View::make('user.show',['user'=> $user]);
		} else {
			App::abort(403);
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
		$user =	User::find($id);
		if ((Auth::user()->has_role('admin')) || (Auth::user()->id == $user->id )) {
				return View::make('user.edituser')
					->with('user', $user);
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
		$user 		= 	User::find($id);

		if ($user){
			$params = $this->userParams();

			$rules = array(
						'firstname'			=>	'required',
						'lastname'			=>	'required',
						'phone_number'		=> 	'',
						'password'			=> 	'confirmed',
						'password_confirmation' => '',
						'gender'			=> '',
						'postcode'			=> ''
					);

			if (strlen($params['password'])) {
				$rules['password'] = 'confirmed|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/';
			}

		$validator = Validator::make($params, $rules);

		if($validator->fails()){
			return Redirect::route('users.edit', ['id' => $user->id])
				->withErrors($validator)
				->withInput(Input::except('password'))
				->with('error', 'Passwords must contain at least eight characters, including uppercase, lowercase letters and numbers.');
		} else {


			$user->firstname 		= 	$params['firstname'];
			$user->lastname			=	$params['lastname'];
			$user->phone_number		=	$params['phone_number'];
			$user->project_code		= 	$params['project_code'];
			$user->gender           =   $params['gender'];

			if (array_key_exists('email', $params) && empty($params['email'])) {
						unset($params['email']);
					}

			if (!empty($params['password'])) {
				$user->password 		= 	$params['password'];
			}
			if (Auth::user()->has_role('admin')) {
				$user->role_id 			= 	$params['role_id'];
			}

		if ((Auth::user()->has_role('admin') || Auth::user()->id == $user->id) && ($user->save())) {
				return Redirect::back()
					->with('message', 'You have successfully edited your profile!');
			} else {
				return Redirect::route('users.edit', ['user' =>$user->id])
					->withInput(Input::except('password'))
					->withErrors($validator);
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
		$user = User::find($id);
		if (Auth::user()->has_role('admin') && $user->delete()){

			return Redirect::back()
				->with('message', 'User deleted!');
		} else {
			return Redirect::route('users.index')
				->with('error', 'An error occurred.');
	}
	}

	private function userParams() {
			$params =  Input::only(['title', 'firstname' ,'lastname', 'position', 'organisation', 'phone_number', 'email', 'password',
			 'password_confirmation', 'role_id', 'gender', 'postcode', 'age', 'country', 'project_code', 'subrole_id', 'user_defined']);
			return $params;
		}
}
