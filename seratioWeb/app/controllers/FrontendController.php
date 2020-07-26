<?php

class FrontendController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('frontend.index');
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

	public function showAbout(){
		return View::make('frontend.about');
	}

	public function showPartners(){
		return View::make('frontend.partners');
	}

	public function showLegal(){
		return View::make('frontend.legal');
	}

	public function showServices(){
		return View::make('frontend.services');
	}

	public function showSeratio(){
		return View::make('frontend.seratio');
	}

	public function showContact(){
		return View::make('frontend.contact');
	}

	public function showPersonal(){
		//return URL::to('http://www.serat.io');
		return Redirect::to('http://www.serat.io');
	}

	public function showTeam() {
		return View::make('frontend.team');
	}

	public function showPV() {
		$pv = null;
		return View::make('frontend.newpv')->with('pv', $pv);
	}

	/*public function showPVTest() {
		$pv = null;
		return View::make('frontend.newpv')->with('pv', $pv);
	}*/

	public function showFeedback() {
		$key = Input::get('token');
		$token = Encryption::decrypt($key);
		$user = User::find($token);
		if($user) {
			$name = $user->firstname.' '.$user->lastname;
			$firstname = $user->firstname;
			$gender = $user->gender;
			return View::make('frontend.feedback')->with('token', $key)->with('name', $name)->with('firstname', $firstname)->with('gender', $gender);
		} else {
			App::abort(403);
		}
	}

	public function getContactUsForm() {

		$data = Input::all();


		$rules = array(
			'message' => 'required|min:5',
			'email' 	=> 'required|email',
			'g-recaptcha-response' => 'required'
			);

		$validator = Validator::make($data, $rules);

		if($validator->fails()) {
			return Redirect::back()
			->withErrors($validator)
			->withInput();
		} else {
			$client = new GuzzleHttp\Client();


			$res = $client->post('https://www.google.com/recaptcha/api/siteverify?secret=6LcWgVwUAAAAAEJJI6GNUfxYdhFwb8sulBcbB7yL&response='.Input::get('g-recaptcha-response'));

			$body = $res->getBody();

			$body = json_decode($body, true);
			$isHuman = $body['success'];
			if ($isHuman) {
				$name = Input::get('name') ? Input::get('name'): null;
				$email = Input::get('email') ? Input::get('email') : null;
				$subject = Input::get('subject') ? Input::get('subject') : null;
				$value = Input::get('message') ? Input::get('message') : null;

				$data = ['name' => $name, 'email' => $email, 'subject' => $subject , 'value'=> $value ];
				Mail::send('emails.contactus', $data, function($message) use ($data)
				{
					$message->to('abhijith.nair@seratio.com', 'Seratio')->subject('Contact Us Form Submit');
				});

				return Redirect::back()
					->with('message', 'Your request has been sent. We will contact you soon.');
			} else {
				return Redirect::back()
					->with('error', 'Captcha validation failed. Please try again');
			}
		}

	}
}
