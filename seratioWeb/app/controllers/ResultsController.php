<?php

class ResultsController extends \BaseController {

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
		if(Auth::user()->has_role('admin')) {
			$svresult = Svresult::where('socialvalue_id', Input::get('id'))->get();

			$socialvalue = Socialvalue::find(Input::get('id'));

			if($socialvalue) {

				$user = DB::select(DB::raw('select organisation from users where id =:user_id'), array(
						'user_id' => $socialvalue->user_id));
			}

			if($user && $svresult->isEmpty() ){
				return View::make('result.add')
					->with('user', $user);
			} else {
				return Redirect::route('socialvalue.index')
					->with('message', 'Result is already existed');
			}

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
		//
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
