<?php

class PasswordController extends \BaseController {

	public function remind() {
		return View::make('password.reminder');
	}


	public function request() {

		$email = Input::get('email');

		$credentials = array(
			'email' => Input::get('email'),
			'password' => Input::get('password'));

		if(!empty($email)) {
			$password = Password::remind($credentials, function($message, $user) {
				$message->subject("$user->firstname, here's the link to reset your password");
			});
			return Redirect::route('sessions.login')
			->with('message', "Password reset request was sent. You'll receive an email shortly if the email address is valid.");
		} else {
			return Redirect::route('sessions.login')->with('message', ' Please enter a valid email address');
		}

	}


	public function reset($token) {
		return View::make('password.reset')->with('token', $token)->with('message', 'test');
	}


	public function update()
	{
		$rules = array(
						'email'				=>	'required',
						'password'			=> 	'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/|confirmed',
						'password_confirmation'	=>	''

					);

		$validator = Validator::make(Input::all(), $rules);

		if($validator->fails()){
				return Redirect::back()
					->withInput(Input::except('password'))
					->with('error_msg', 'Passwords must contain at least eight characters, including uppercase, lowercase letters and numbers.');
		} else {

			$credentials = array('email' => Input::get('email'), 'password' => Input::get('password'), 'password_confirmation' => Input::get('password_confirmation'), 'token' => Input::get('token'));

			$password = Password::reset($credentials, function($user, $password) {
				$user->password = $password;
				$user->save();

			});

			if($password == "reminders.reset") {
				return Redirect::route('sessions.login')->with('message', 'Your password has been changed successfully');
			} elseif($password == "reminders.user") {
				return Redirect::back()->with('error_msg', "We couldn't find the user. Please try again");
			} elseif($password == "reminders.password") {
				return Redirect::back()->with('error_msg', 'Invalid Password');
			} elseif($password == "reminders.token") {
				return Redirect::back()->with('error_msg', 'Invalid token. Please make sure the email is correct' );
			}
		}
	}
}
