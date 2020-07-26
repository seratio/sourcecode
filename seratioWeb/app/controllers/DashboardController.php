<?php

class DashboardController extends \BaseController {

	/**
	* Display a listing of the resource.
	*
	* @return Response
	*/
	public function index()
	{
		if (Auth::guest()) {
			return View::make('frontend.index');
		} elseif (Auth::user()->has_role('admin')) {
			return View::make('dashboard.welcome');
		} elseif (Auth::user()->has_role('public')) {
			return View::make('dashboard.welcome');
		} elseif (Auth::user()->has_role('private')) {
			return View::make('dashboard.welcome');
		} elseif (Auth::user()->has_role('third')) {
			return View::make('dashboard.welcome');
		} elseif (Auth::user()->has_role('individual')) {
			$user_id = Auth::user()->id;
			if($user_id>0) {
				//$pv = Pvalue::personalValue($user_id);
				$quick_pv = Pvalue::quickPV($user_id);
				if($quick_pv){

					$added_sv = ($quick_pv->pv*$quick_pv->question4)-$quick_pv->question4;
					if($added_sv) {
						$increase_worth = $added_sv/$quick_pv->question2;
					} else {
						$increase_worth = null;
					}
				} else {
					$added_sv = null;
				}
				$pv = Pvalue::where('user_id', Auth::user()->id)->first();
				$avg = $pv->pv;
				$updated_at = $pv->updated_at;
				$count = $pv->counter ? $pv->counter : 0;
				$added_sv_d = ($avg*$quick_pv->question4)-$quick_pv->question4;
				$increase_worth_d = $added_sv_d/$quick_pv->question2;
			}
			$shorturl  = Encryption::generateShortUrl( Encryption::encrypt($user_id));

			$percentaile = DB::select(DB::raw("select users.id, pvalues.pv, pvalues.id as pvalue_id from users left join pvalues on pvalues.user_id = users.id
			WHERE users.role_id = 4 group by users.id order by pvalues.pv"));


			$percentaile = (array)$percentaile;
			$result = array();

			foreach ($percentaile as $key => $value) {
				$result[$value->id] = $value->pv;
			}

			$total = (count(array_keys($result))) ? (count(array_keys($result))): null;
			$index = (array_search(Auth::user()->id, array_keys($result)))? array_search(Auth::user()->id, array_keys($result)) : null;
			if($total!=null && $index!=null ){
				$perc = ($index/$total)*100;
			} else {
				$perc = 0;
			}

			$gender = Auth::user()->gender;

			$avg_pos = Feedback::where('pvalue_id', $pv->id)->avg('pv');

			return View::make('dashboard.pv')
			->with([
				'shorturl' => $shorturl,
				'quick_pv'=> $quick_pv,
				'added_sv' => $added_sv,
				'increase_worth'=> $increase_worth,
				'avg'			=> $avg,
				'added_sv_d' 	=> $added_sv_d,
				'increase_worth_d' => $increase_worth_d,
				'count' 			=> $count,
				'perc'				=> $perc,
				'gender'			=> $gender,
				'avg_pos'			=> $avg_pos,
				'updated_at'		=> $updated_at

			]);

		} elseif(Auth::user()->has_role('CUSWM001') || Auth::user()->has_role('CUSWC002') || Auth::user()->has_role('CUSBN003') || Auth::user()->has_role('CUSEC004') || Auth::user()->has_role('CUSSC005') ||
		Auth::user()->has_role('CUSBS006') || Auth::user()->has_role('CUSCB007') || Auth::user()->has_role('CUSHC008') || Auth::user()->has_role('CUSHC009') ||
		Auth::user()->has_role('CUSWF010') || Auth::user()->has_role('CUSCL011') || Auth::user()->has_role('CUSWU012') || Auth::user()->has_role('CUSWD013') || Auth::user()->has_role('CUSNM014') ){

			if(Auth::user()->user_defined && Auth::user()->has_subrole('supplier')) {
				$contracts = Wmcontractbid::where('user_id', Auth::user()->id)->get();

				return Redirect::route('suppliers.create');
				//return View::make('wmfs.supplier')->with('contracts', $contracts);
			}elseif(Auth::user()->user_defined && Auth::user()->has_subrole('customer')){
				//$contracts = Wmcuscontract::where('user_id', Auth::user()->id)->get();
				$contracts = Wmcuscontract::where('role_id', Auth::user()->role_id)->get();
				$tenders = Wmtender::where('user_id', Auth::user()->id)->get();
				$compliance = Wmcompliance::where('user_id', Auth::user()->id)->first();
				$user = User::find(Auth::user()->id);
				$wmfs = Wmfs::where('role_id', Auth::user()->role_id)->orderBy('measured_year', 'desc')->get();
				$wmfsArray = $wmfs->toArray();
				$modernSlavery = Modernslavery::where('user_id', Auth::user()->id)->get();
				return View::make('wmfs.customer')
										->with('contracts', $contracts)
										->with('tenders', $tenders)
										->with('compliance', $compliance)
										->with('user', $user)
										->with('wmfs', $wmfs)
										->with('wmfsArray', $wmfsArray)
										->with('modernSlavery', $modernSlavery);
			} else {
				return View::make('wmfs.first');
			}
		} elseif(Auth::user()->has_role('eu')){
			$eu = Eu::where('user_id', Auth::user()->id)->first();
			if($eu){
				$companies = DB::select(DB::raw("select users.id, eus.added_social_value, eus.id as eu_id from eus left join users on users.id = eus.user_id
				WHERE users.role_id = 7 group by users.id order by eus.added_social_value"));

				$companies = (array)$companies;
				$company_result = array();

				foreach ($companies as $key => $value) {
					$company_result[$value->id] = $value->added_social_value;
				}

				$company_total = (count(array_keys($company_result))) ? (count(array_keys($company_result))): null;
				$company_index = (array_search(Auth::user()->id, array_keys($company_result)))? array_search(Auth::user()->id, array_keys($company_result)) : null;

				if($company_total!=null && $company_index!=null ){
					$comp = ($company_index/$company_total)*100;
				} else {
					$comp = 0;
				}

				$accelerator = DB::select(DB::raw("select users.id, eus.added_social_value, eus.id, eus.fiware as fiware from eus left join users on users.id = eus.user_id
				WHERE users.role_id = 7 AND eus.fiware = 'A2 EuropeanPioneers' order by eus.added_social_value"));

				$accelerators = (array)$accelerator;
				$accelerator_result = array();

				foreach ($accelerators as $key => $value) {
					$accelerator_result[$value->id] = $value->added_social_value;
				}

				$accelerator_total = (count(array_keys($accelerator_result))) ? (count(array_keys($accelerator_result))): null;
				$accelerator_index = (array_search(Auth::user()->id, array_keys($accelerator_result)))? array_search(Auth::user()->id, array_keys($accelerator_result)) : null;

				if($accelerator_total!=null && $accelerator_index!=null ){
					$acce = ($accelerator_index/$accelerator_total)*100;
				} else {
					$acce = 0;
				}
				return View::make('eu.index')->with('eu', $eu)->with('comp', $comp)->with('acce', $acce);
			} else {
				App::abort(404);
			}

		} elseif(Auth::user()->has_role('ms')) {
			if(Auth::user()->has_subrole('customer')) {
				return Redirect::route('modernslavery.create', 'basic');
			} else {
				App::abort(404);
			}
		} elseif(Auth::user()->has_role('pslight')) {
			return Redirect::route('microsite.create');
		} elseif(Auth::user()->has_role('Bidder')) {
			if(Auth::user()->user_defined) {
				$contracts = Wmconbidder::where('user_id', Auth::user()->id)->get();
				$no_of_contracts = $contracts->count();
 	 			return View::make('bidder.index')->with('contracts', $contracts)->with('no_of_contracts', $no_of_contracts);
			} else {
				return View::make('bidder.first');
			}
		} else {
			App::abort(400);
		}
	}


	public function getXML()
	{

		if(Auth::user()){

			$content  = file_get_contents("http://abhijithrnair.co.uk/final/api_multi.php?id=1");
			file_put_contents("stockoutput.xml", $content);
			$content = simplexml_load_file("stockoutput.xml");


			$html               =        '<table class="table table-bordered">
			<tr>
			<th>#</th>
			<th>Index</th>
			<th style="width: 40px">Value</th>
			</tr>

			<tr>
			<td> 1 </td>
			<td> Share Price </td>
			<td>'.$content->sharePriceValue.'</td>
			</tr>

			<tr>
			<td> 2 </td>
			<td> Market Cap (&#163;b) </td>
			<td>'.$content->marketCapValue.'</td>
			</tr>
			<tr>
			<td>3</td>
			<td> SER </td>
			<td>'.$content->serValue.'</td>
			</tr>

			<tr>
			<td> 4 </td>
			<td> Social Impact (&#163;m) </td>
			<td>'. $content->socialImpactMoneyValue.'</td>
			</tr>

			<tr>
			<td> 5 </td>
			<td> Social Impact as a percentage of Capitalization (%)</td>
			<td>'. $content->socialImpactPercentValue.'</td>
			</tr>

			<tr>
			<td> 6 </td>
			<td> Added Value</td>
			<td> '. $content->addedvalueValue.'</td>
			</tr>
			</table>';

			return $html;
		}
	}

	public function getPilot() {

		if (Auth::guest()) {
			return View::make('frontend.index');
		} elseif (Auth::user()->has_role('admin')) {
			return View::make('dashboard.index');
		} elseif (Auth::user()->has_role('public')) {
			return View::make('dashboard.index');
		} elseif (Auth::user()->has_role('private')) {
			return View::make('dashboard.index');
		} elseif (Auth::user()->has_role('third')) {
			return View::make('dashboard.index');
		} else {
			App::abort(400);
		}
	}

	public function getPLC() {

		if (Auth::guest()) {
			return View::make('frontend.index');
		} elseif (Auth::user()->has_role('admin')) {
			return View::make('dashboard.plc');
		} elseif (Auth::user()->has_role('public')) {
			return View::make('dashboard.plc');
		} elseif (Auth::user()->has_role('private')) {
			return View::make('dashboard.plc');
		} elseif (Auth::user()->has_role('third')) {
			return View::make('dashboard.plc');
		} else {
			App::abort(400);
		}
	}

	public function getWmfs() {

		if(Auth::guest()) {
			return View::make('frontend.index');
		} elseif (Auth::user()->has_role('admin') || Auth::user()->has_role('CUSWM001')){
			return View::make('wmfs.admin');
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

	}


	/**
	* Store a newly created resource in storage.
	*
	* @return Response
	*/
	public function store()
	{

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
