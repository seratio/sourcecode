<?php

class MicrobidsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if(Auth::user()->has_role('pslight')) {
			$bids = Microbid::where('user_id', Auth::user()->id)->get();
			return View::make('microsite.bids.index')->with('bids', $bids);
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
		if(Auth::user()->has_role('pslight')) {
			$microsite = Microsite::where('user_id', Auth::user()->id)->first();
			$type = $microsite->customer_type;

			if($type == 'Gold') {
				$bids = Microbid::where('user_id', Auth::user()->id)->count();

				if($bids>10) {
					return Redirect::route('microbids.index')->with('message', "Sorry, You can't have more than 10 bids. Please upgrade your account to put more bids");
				} else {
					return View::make('microsite.bids.add');
				}
			} elseif($type == 'Platinum') {
				$bids = Microbid::where('user_id', Auth::user()->id)->count();
				if($bids>20) {
					return Redirect::route('microbids.index')->with('message', "Sorry, You can't have more than 10 bids. Please upgrade your account to put more bids");
				} else {
					return View::make('microsite.bids.add');
				}
			} elseif($type == 'Enterprise'){
					return View::make('microsite.bids.add');
			} else {
				App::abort(404);
			}

		}
	}



	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

		if(Auth::user()->has_role('pslight')){
			$microsite = Microsite::where('user_id', Auth::user()->id)->first();
			$type = $microsite->customer_type;

			if($type == 'Gold'){

				$rules = array(
						'user_id' 						=> 'required',
						'bid_name'						=> 'required',
						'bid_date'						=> 'required',
						'price'							=> 'required|numeric|max:1000000',
						'added_social_value'			=> 'required|numeric',
						'people'						=> 'required|numeric',
						'cash' 							=> 'required|numeric',
						'environment'					=> 'required|numeric',
						);

			} elseif ($type == 'Platinum') {
				$rules = array(
						'user_id' 						=> 'required',
						'bid_name'						=> 'required',
						'bid_date'						=> 'required',
						'price'							=> 'required|numeric|max:3000000',
						'added_social_value'			=> 'required|numeric',
						'people'						=> 'required|numeric',
						'cash' 							=> 'required|numeric',
						'environment'					=> 'required|numeric',
						);
			}elseif($type == 'Enterprise') {
				$rules = array(
						'user_id' 						=> 'required',
						'bid_name'						=> 'required',
						'bid_date'						=> 'required',
						'price'							=> 'required|numeric|',
						'added_social_value'			=> 'required|numeric',
						'people'						=> 'required|numeric',
						'cash' 							=> 'required|numeric',
						'environment'					=> 'required|numeric',
						);
			} else {
				App::abort(404);
			}

				$validator = Validator::make(Input::all(), $rules);

				if($validator->fails()) {
						//return $validator->messages()->toJson();
					return Redirect::back()
					->withErrors($validator)
					->withInput();
				} else {

					$bid = new Microbid;

					$bid->user_id = Auth::user()->id;
					$bid->microsite_id = $microsite->id;
					$bid->bid_name = Input::get('bid_name') ? Input::get('bid_name') : null;
					$bid->bid_date = Input::get('bid_date') ? Input::get('bid_date') : null;
					$bid->price = Input::get('price') ? Input::get('price') : null;
					$bid->added_social_value = Input::get('added_social_value') ? Input::get('added_social_value') : null;
					$bid->people = Input::get('people') ? Input::get('people') : null;
					$bid->cash = Input::get('cash') ? Input::get('cash') : null;
					$bid->environment = Input::get('environment') ? Input::get('environment') : null;

					if($bid->save()) {
						return Redirect::back()->with('message', 'You have successfully saved the data');
					} else {
						return Redirect::back()->with('message', 'Something went wrong. Please try again');
					}
				}
		} else {
			App::abort(404);
		}


	}

	public function viewBids($id) {

		if(Auth::user()->has_role('admin') && $id!=0) {
			$microsite = Microsite::find($id);
			$bids = Microbid::where('user_id', $microsite->user_id)->get();
				return View::make('microsite.bids.index')->with('bids', $bids)->with('microsite', $microsite);
		}
	}

	public function addResult($id){
		if(Auth::user()->has_role('admin') && $id!=0) {
					$microsite = Microsite::find($id);
					$bid = Microbid::find($id);
					if($bid) {
						$bid->annual_price = Input::get('annual_price') ? Input::get('annual_price') : null;
						$bid->social_value = Input::get('social_value') ? Input::get('social_value') : nulll;
						$bid->total 		= Input::get('total') ? Input::get('total') : null;
						$bid->save();
						return Redirect::back()->with('message', 'You have successfully added the result');
					} else {
						App::abort(404);
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
