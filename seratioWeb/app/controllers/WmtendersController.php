<?php

class WmtendersController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if(Auth::user()->has_role('admin')){
			$user_id = Input::get('id') ? Input::get('id') : null;
			if($user_id > 0){
				$tenders = Wmtender::where('user_id', $user_id)->get();
				$user = User::find($user_id);
				return View::make('wmfs.admin.tender')->with('tenders', $tenders)->with('user', $user);
			} else {
				$user = User::find($user_id);
				$tenders = null;
				return View::make('wmfs.admin.tender')->with('tenders', $tenders)->with('user', $user);
			}
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
		if(Auth::user()->has_role('admin')) {

			return View::make('wmfs.admin.tender');

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
		if(Auth::user()->has_role('admin')) {

			$rules = array(
				'user_id'							=> 'required',
				'contract_name'						=> 'required',
				'estimated_price'					=>	'required',
				'tender'							=>	'required',
				'social_value_act'					=> 'required',
				'modern_slavery_act' 				=> 'required',
				'contract_value'					=> 'required',
				'added_social_value'				=> 'required',
				'people'							=> 'required',
				'cash' 								=> 'required',
				'environment'						=> 'required',
				'hyperlocality'						=> 'required',
				'pay_disparity'						=> 'required',
				'tax_avoidance' 					=> 'required',
				'sv_as_perc_contract_value'			=> 'required',
				'kpi1'								=> 'required',
				'kpi2'								=> 'required',
				'final_score' 						=> 'required',
				'price_scoring'						=> 'required',
				'quality_scoring'					=> 'required',
				'social_value_scoring'				=> 'required',
			);



			$validator = Validator::make(Input::all(), $rules);

			if($validator->fails()) {
				return Redirect::route('tenders.create')
					->withErrors($validator)
					->withInput();
			} else {
				$tender = new Wmtender($this->tenderParams());
				if(Auth::user()->has_role('admin') && $tender->save()) {

					return Redirect::back()
						->with('message', 'You have successfully added a Tender');

					} else {
						App::abort(404);
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
		$tender = Wmtender::find($id);

		if(Auth::user()->has_role('admin') && $tender->delete()){
			return Redirect::back()
			->with('message', 'The Tender has been deleted');
		} else {
			return Redirect::back()
			->with('message', 'You dont have access to delete this record. Please contact the site admin');
		}
	}

	private function tenderParams() {
		return Input::only(['user_id', 'contract_name', 'estimated_price', 'tender','social_value_act',
		'modern_slavery_act','contract_value', 'added_social_value', 'people', 'cash', 'environment', 'hyperlocality', 'pay_disparity',
		'tax_avoidance', 'sv_as_perc_contract_value', 'kpi1', 'kpi2', 'final_score', 'price_scoring',
		'quality_scoring', 'social_value_scoring']);
	}


}
