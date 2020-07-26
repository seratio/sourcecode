<?php

class ModernSlaverySupplierController extends \BaseController {

/**
* Display a listing of the resource.
*
* @return Response
*/
public function index() {
	if (Auth::user()->has_role('admin') || (Auth::user()->has_role('ms') && Auth::user()->has_subrole('customer'))) {
		$suppliers = Mssupplier::where('user_id', Auth::user()->id)->get();
		$ms = Mscustomer::where('user_id', Auth::user()->id)->first();
		return View::make('ms.supplier.index')->with('suppliers', $suppliers)->with('ms', $ms);
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
if(Auth::user()->has_role('admin') || (Auth::user()->has_role('ms') && Auth::user()->has_subrole('customer'))) {

	$customer = Mscustomer::where('user_id', Auth::user()->id)->first();
	$current_url = URL::full();
	$sectors  = MSlavery::sectors();
	$industries = MSlavery::industries();
	$con = Country::countries();
	$currencies = MSlavery::currencies();
	$ms = Mscustomer::where('user_id', Auth::user()->id)->first();

	return View::make('ms.supplier.add')
	->with(['customer' => $customer,
		'sectors' => $sectors,
		'industries' => $industries,
		'con' => $con,
		'currencies' => $currencies,
		'ms' 	=> $ms]);

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

$rules = array(
	'customer_id'						=> 'required',
	'user_id' 							=> 'required',
	'supplier_name'						=> 'required',
	'number_street'						=> 'required',
	'city'								=> 'required',
	'county'							=> 'required',
	'post_code'							=> 'required',
	'country' 							=> 'required',
	'email'								=> 'required|email|unique:mssuppliers,email,NULL,id,customer_id,'.Input::get('customer_id').'',
	'sector'							=> 'required',
	'main_industry'						=> 'required',
	);

$validator = Validator::make(Input::all(), $rules);

if($validator->fails()) {
		//return $validator->messages()->toJson();
	return Redirect::back()
	->withErrors($validator)
	->withInput();
} else {

	$supplier = new Mssupplier($this->msParams());
	$supplier->supplier_number = strtoupper(substr(md5(uniqid(Input::get('email'), true)), 0, 10));

	if(Auth::user()->has_role('ms') && $supplier->save()) {
		if(!Auth::user()->has_role('admin')){

			$customer = Mscustomer::where('customer_number', $supplier->customer_number)->first();
			$customer_name = $customer->customer_name ? $customer->customer_name : "Unknown";

			$data = ['customer_number' => $supplier->customer_number, 'supplier_number' => $supplier->supplier_number, 'customer_name' => $customer_name ];
			Mail::send('emails.msupplier', $data, function($message)
			{
				$message->to(Input::get('email'), Input::get('supplier_name'))
				->subject('Modern Slavery - You are added as a supplier');
			});

		}
		return Redirect::route('mssupplier.index')
		->with('message', 'You have successfully added a supplier');
	} else {
		return Redirect::back()->with('message', 'Something went wrong. Please try again');
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
if(Auth::user()->has_role('ms') && Auth::user()->has_subrole('customer')) {
	$supplier = Mssupplier::find($id);
	$ms = Mscustomer::find($supplier->customer_id);
	if($supplier) {
		$surveys = Mssurvey::where('supplier_id', $supplier->id)->get();

		$supp = DB::select(DB::raw("SELECT
			SUM(CASE WHEN supplier_name IS NOT NULL THEN 1 ELSE 0 END)/COUNT(*)*100 AS supplier_name,
			SUM(CASE WHEN number_street IS NOT NULL THEN 1 ELSE 0 END)/COUNT(*)*100 AS number_street,
			SUM(CASE WHEN city IS NOT NULL THEN 1 ELSE 0 END)/COUNT(*)*100 AS city,
			SUM(CASE WHEN county IS NOT NULL THEN 1 ELSE 0 END)/COUNT(*)*100 AS county,
			SUM(CASE WHEN post_code IS NOT NULL THEN 1 ELSE 0 END)/COUNT(*)*100 AS post_code,
			SUM(CASE WHEN country IS NOT NULL THEN 1 ELSE 0 END)/COUNT(*)*100 AS country,
			SUM(CASE WHEN email IS NOT NULL THEN 1 ELSE 0 END)/COUNT(*)*100 AS email,
			SUM(CASE WHEN sector IS NOT NULL THEN 1 ELSE 0 END)/COUNT(*)*100 AS sector,
			SUM(CASE WHEN main_industry IS NOT NULL THEN 1 ELSE 0 END)/COUNT(*)*100 AS main_industry,
			SUM(CASE WHEN currency IS NOT NULL THEN 1 ELSE 0 END)/COUNT(*)*100 AS currency,
			SUM(CASE WHEN total_revenue IS NOT NULL THEN 1 ELSE 0 END)/COUNT(*)*100 AS total_revenue,
			SUM(CASE WHEN total_wages IS NOT NULL THEN 1 ELSE 0 END)/COUNT(*)*100 AS total_wages,
			SUM(CASE WHEN no_of_employees IS NOT NULL THEN 1 ELSE 0 END)/COUNT(*)*100 AS no_of_employees,
			SUM(CASE WHEN document1 IS NOT NULL THEN 1 ELSE 0 END)/COUNT(*)*100 AS document1
			FROM  mssuppliers where id = '$supplier->id'"));

	if($supp) {
		foreach ($supp as $supp) {
		}

		$basic_info = ($supp->supplier_name+$supp->number_street+$supp->city+$supp->county+$supp->post_code+$supp->country+$supp->email+$supp->sector+$supp->main_industry)/9;
		$pay  = ($supp->currency+$supp->total_revenue+$supp->total_wages+$supp->no_of_employees+$supp->document1)/5;


	} else {
		$basic_info = 0;
		$pay = 0;
	}

	$sentiment = $supplier->sentiment ? 100 : 0;

	return View::make('ms.supplier.show')->with('supplier', $supplier)->with('surveys', $surveys)->with('basic_info', $basic_info)->with('pay', $pay)->with('sentiment', $sentiment)->with('ms', $ms);
} else {
	return Redirect::back()->with('message', 'Something went wrong. Please try again');
}
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

public function getauthSupplier() {

return View::make('ms.supplier.auth');
}

public function authSupplier() {

$rules = array(
	'supplier_number'  	=> 'required',
	'customer_number'  => 'required'
	);

$validator = Validator::make(Input::all(), $rules);

if ($validator->fails()){
	return Redirect::route('ms.supplier.auth')
	->withErrors($validator)
	->withInput();
}

else {

	$supplier = Mssupplier::where('supplier_number', Input::get('supplier_number'))->first();

	if ($supplier) {

		if($supplier->customer_number == Input::get('customer_number')) {
			$currencies = MSlavery::currencies();
			return View::make('ms.supplier.insert')->with('supplier', $supplier)->with('currencies', $currencies);
		} else {
			return Redirect::back()->with('message', 'Please enter the correct details')->withInput();
		}
	} else {
		return Redirect::back()->with('message', 'It seems the supplier is not registered in our system')->withInput();
	}
}
}

public function updateSupplier($id) {

//dd(Input::all());

$file = Input::file('document1');

$rules  = array(
	'supplier_another_check' 	=> 'required',
	'supplier_another' 			=> '',
	'total_revenue' 			=> 'required|numeric',
	'currency'					=> 'required',
	'total_wages'				=> 'required|numeric',
	'no_of_employees'			=> 'required|numeric',
	'sentiment_q1'				=> 'required',
	'sentiment_q2'				=> 'numeric',
	'sentiment_q3'				=> 'numeric',
	'sentiment_q4'				=> '',
	'document1' 				=> 'mimes:txt,pdf,doc,xls,ppt,rtf',
	);

$validator = Validator::make(Input::all(), $rules);

if($validator->fails()) {
	$supplier = Mssupplier::find($id);
	return Redirect::back()->withInput()->withErrors($validator)->with('supplier', $supplier);
} else {
	$supplier = Mssupplier::find($id);
	if($supplier) {
		$supplier->supplier_another_check	= Input::get('supplier_another_check') ? Input::get('supplier_another_check') : $supplier->supplier_another_check;
		$supplier->supplier_another   	 	= Input::get('supplier_another') ? Input::get('supplier_another') : $supplier->supplier_another;
		$supplier->total_revenue 		    = Input::get('total_revenue') ? Input::get('total_revenue') : $supplier->total_revenue;
		$supplier->currency   	 			= Input::get('currency') ? Input::get('currency') : $supplier->currency;
		$supplier->total_wages   	 		= Input::get('total_wages') ? Input::get('total_wages') : $supplier->total_wages;
		$supplier->no_of_employees   	 	= Input::get('no_of_employees') ? Input::get('no_of_employees') : $supplier->no_of_employees;
		$supplier->sentiment_q1				= Input::get('sentiment_q1') ? true : false;
		$supplier->sentiment_q2				= Input::get('sentiment_q2') ? Input::get('sentiment_q2') : $supplier->sentiment_q2;
		$supplier->sentiment_q3				= Input::get('sentiment_q3') ? Input::get('sentiment_q3') : $supplier->sentiment_q3;
		$supplier->sentiment_q4				= Input::get('sentiment_q4') ? Input::get('sentiment_q4') : $supplier->sentiment_q4;

		if($file) {

			$size = $file->getSize();

			if($size > 1048576 * 2) {
				return Redirect::back()->withInput()->with('message', 'File is too large. File must be less than 2MB in size');
			} else {
				$path = public_path(). "/uploads/customers/".$supplier->customer_number."/suppliers/".$supplier->supplier_number;

				if(!file_exists($path)) {
					mkdir($path, 0777, true);
				}

				if($supplier->document1) {
					$existing = public_path()."/".$supplier->document1;
					File::delete($existing);
					$supplier->document1 = null;

				}

				Input::file('document1')->move($path . "/", $file->getClientOriginalName());
				$supplier->document1 = "uploads/customers/".$supplier->customer_number."/suppliers/".$supplier->supplier_number."/".$file->getClientOriginalName();

			}
		}

		$supplier->save();

		if($supplier->sentiment_q1 == 0){

			$customer = Mscustomer::where('customer_number', $supplier->customer_number)->first();

			$customer_name = $customer->customer_name;

			$data = ['customer_number' => $supplier->customer_number, 'supplier_number' => $supplier->supplier_number, 'customer_name' => $customer_name];

			Mail::send('emails.survey', $data, function($message) use($supplier)
			{
				$message->to($supplier->email,  $supplier->supplier_name)
				->subject('Modern Slavery - Please Complete the Sentiment Survey');
			});
			return Redirect::back()->with('success', 'Thank You. You have successfully updated your details, please check your email for the link to complete your online sentiment survey. Please share this with your employees to complete');
		} else {
			return Redirect::back()->with('success', 'You have successfully updated the details');
		}

	} else {
		return Redirect::back()->with('message', 'Something went wrong');
	}

}
}

public function getSupplierSurvey($id) {
if($id) {
	$supplier = Mssupplier::where('supplier_number', $id)->first();
	$con = Country::countries();

	if ($supplier){
		return View::make('ms.survey')->with('supplier', $supplier)->with('con', $con);
	} else {
		return View::make('ms.survey');
	}

} else {
	App::abort(404);
}

}

public function saveSupplierSurvey($id) {

if($id) {
	$rules  = array(
		'supplier_number' 			=> 'required',
		'customer_number' 			=> 'required',
		'country' 					=> 'required',
		'question_1'				=> 'required',
		'question_2'				=> 'required',
		'question_3'				=> 'required',
		'question_4'				=> 'required',
		'question_5'				=> 'required',
		'question_6'				=> 'required',
		'question_7'				=> 'required',
		'question_8'				=> 'required',
		'question_9'				=> 'required',
		'question_10'				=> 'required',
		);

	$validator = Validator::make(Input::all(), $rules);

	if($validator->fails()) {
		return Redirect::back()
		->withInput()
		->withErrors($validator);
	} else {

		$survey = new Mssurvey;
		$survey->supplier_id        	=	$id;
		$survey->supplier_number 		= 	Input::get('supplier_number');
		$survey->customer_number		= 	Input::get('customer_number');
		$survey->country 				= 	Input::get('country');
		$survey->question_1				=	Input::get('question_1');
		$survey->question_2				=	Input::get('question_2');
		$survey->question_3				=	Input::get('question_3');
		$survey->question_4				=	Input::get('question_4');
		$survey->question_5				=	Input::get('question_5');
		$survey->question_6				=	Input::get('question_6');
		$survey->question_7				=	Input::get('question_7');
		$survey->question_8				=	Input::get('question_8');
		$survey->question_9				=	Input::get('question_9');
		$survey->question_10			=	Input::get('question_10');
		$survey->survey_type 			= 	'supplier';

		if($survey->save()) {
			return Redirect::back()->with('message', 'You have successfully completed the survey');
		} else {
			return Redirect::back()->with('message', 'Something went wrong. Please try again');
		}
	}
} else {
	App::abort(404);
}
}

public function addResult($id) {

if($id && Auth::user()->has_role('admin')){
	$supplier = Mssupplier::find($id);
	$supplier->modern_slavery = Input::get('modern_slavery') ? Input::get('modern_slavery') : null;
	$supplier->sentiment = Input::get('sentiment') ? Input::get('sentiment') : null;
	if($supplier->save()) {
		return Redirect::back()->with('message', 'You have successfully added results');
	} else {
		return Redirect::back()->with('message', 'Something went wrong, Please try again')->with('error_code', 5);;
	}
} else {
	App::abort(404);
}
}

private function msParams() {
return Input::only(['customer_id','customer_number','user_id', 'supplier_name', 'number_street', 'city', 'county',
	'post_code', 'country', 'email',
	'sector', 'main_industry', 'currency', 'total_revenue', 'total_wages',
	'no_of_employees','sentiment_q1', 'sentiment_q2', 'sentiment_q3', 'document1',
	'document2', 'document3', 'document4', 'document5']);
}


}
