<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('', function() {
	if (Auth::guest()) {
		return Redirect::route('home.index');
	} else {
		return Redirect::route('dashboard.index');
	}
});

Route::any('api', ['as' => 'api', 'uses' => 'ApiController@entry']);

//Session && Users Routes
Route::resource('users', 'UsersController');
Route::get('users/create/{eu}', ['uses' => 'UsersController@create', 'as' => 'users.eu']);
Route::resource('subscribe', 'SubscribeController');
Route::post('subscribe/unsubscribe', array('uses' => 'SubscribeController@postAction'));
Route::get('login', ['uses' => 'SessionsController@create', 'as' => 'sessions.login']);
Route::get('signin', ['uses' => 'SessionsController@pvLogin', 'as' => 'sessions.signin']);
Route::post('login', ['uses' => 'SessionsController@store' ,'as' => 'sessions.action']);
Route::get('logout', ['uses' => 'SessionsController@destroy', 'as' => 'sessions.logout']);
Route::get('password/reset', array('uses' => 'PasswordController@remind','as' => 'password.remind'));
Route::post('password/reset', array('uses' => 'PasswordController@request','as' => 'password.request'));
Route::get('password/reset/{token}', array('uses' => 'PasswordController@reset','as' => 'password.reset'));
Route::post('password/reset/{token}', array('uses' => 'PasswordController@update','as' => 'password.update'));

//Dashbord Routes
Route::resource('dashboard', 'DashboardController');
Route::get('livedata', ['uses'=>'DashboardController@getXML', 'as'=>'dashboard.livedata']);
Route::get('pilot', ['uses' => 'DashboardController@getPilot', 'as' =>'dashboard.pilot']);
Route::get('plc', ['uses' => 'DashboardController@getPLC', 'as' => 'dashboard.plc']);
Route::get('wmfs_dashboard', ['uses' => 'DashboardController@getWmfs', 'as' => 'dashboard.wmfs']);

//Socialvalue routes
Route::resource('socialvalue', 'SocialvaluesController');
Route::post('addresult/{id}', ['uses' => 'SocialvaluesController@addResult', 'as'=>'result.add']);
Route::post('addquery/{id}', ['uses' => 'SocialvaluesController@addquery', 'as'=>'query.add']);
Route::resource('result', 'ResultsController');

//Personalvalue routes
Route::resource('personalvalue', 'PersonalvalueController');
Route::resource('feedback', 'FeedbackController');
Route::get('pdf', ['uses' => 'PersonalvalueController@getPDF', 'as' => 'personalvalue.pdf']);

//WMFS routes
Route::resource('organisation', 'Wmfscontroller');
Route::resource('suppliers', 'WmfsSupplierController');
Route::resource('customer', 'WmfsCustomerContracts');
Route::resource('tenders', 'WmtendersController');
Route::resource('bidders', 'WmfsbiddersController');
Route::resource('mslavery', 'MSController');
Route::get('addcompliance/{id}', ['uses' => 'Wmfscontroller@getCompliance', 'as'=>'compliance.get']);
Route::post('addcompliance/{id}', ['uses' => 'Wmfscontroller@addCompliance', 'as'=>'compliance.save']);

Route::post('bid/{id}', ['uses' => 'WmfsCustomerContracts@addBid', 'as' => 'wmfs.bid']);

Route::post('addresult/{id}', ['uses' => 'Wmfscontroller@addResult', 'as'=>'result.wmfs']);
Route::post('addquery/{id}', ['uses' => 'Wmfscontroller@addquery', 'as'=>'query.wmfs']);
Route::get('wmfs_users', ['uses' => 'Wmfscontroller@viewUsers', 'as'=>'wmfs.users']);
Route::post('makesupp/{id}', ['uses' => 'Wmfscontroller@makeSupplier', 'as'=>'make.supplier']);
Route::post('makecus/{id}', ['uses' => 'Wmfscontroller@makeCustomer', 'as'=>'make.customer']);
Route::post('makebidder/{id}', ['uses' => 'Wmfscontroller@makeBidder', 'as' => 'make.bidder']);
Route::post('updateResult/{id}', ['uses' => 'WmfsCustomerContracts@updateResult', 'as' => 'contract.result']);
Route::post('updateKnowledgeBase/{id}', ['uses' => 'Wmfscontroller@getKnowledgeBase', 'as' => 'wmfs.knowledge']);
Route::get('manageContracts', ['uses' => 'WmfsSupplierController@getContract', 'as' => 'contracts.manage']);
Route::post('assignContract', ['uses' => 'WmfsSupplierController@assignContract', 'as' => 'contract.assign']);
Route::get('viewContracts', ['uses' => 'WmfsbiddersController@viewContracts', 'as' => 'contracts.view']);
Route::post('assignBidder', ['uses' => 'WmfsbiddersController@assignContract', 'as' => 'bidder.assign']);
Route::delete('deleteContract', ['uses' => 'WmfsbiddersController@deleteAssignedBidder', 'as' => 'bidder.delete']);
Route::get('initiative/{id}', ['uses' => 'WmfsbiddersController@addInitiative', 'as' => 'create.initiative']);
Route::post('initiative/{id}', ['uses' => 'WmfsbiddersController@addBid', 'as' => 'bid.initiative']);
Route::post('updateResult/{id}', ['uses' => 'WmfsbiddersController@updateResult', 'as' => 'result.update']);
//EU Contract
Route::resource('eu', 'EucontractsController');

//Modern Slavery
Route::resource('modernslavery', 'ModernSlaveryController');
Route::resource('mssupplier', 'ModernSlaverySupplierController');
Route::post('addResult/{id}', ['uses' => 'ModernSlaveryController@addResult', 'as' => 'modernslavery.result']);
Route::post('addSuResult/{id}', ['uses' => 'ModernSlaverySupplierController@addResult', 'as' => 'modernslavery.suresult']);
Route::get('ms_users', ['uses' => 'ModernSlaveryController@viewUsers', 'as'=>'modernslavery.users']);
Route::get('supplier', ['uses' => 'ModernSlaverySupplierController@getauthSupplier', 'as' => 'modernslavery.suppliers']);
Route::post('supplier', ['uses' => 'ModernSlaverySupplierController@authSupplier', 'as' => 'modernslavery.action']);
Route::post('updatesupplier/{id}', ['uses' => 'ModernSlaverySupplierController@updateSupplier', 'as' => 'modernslavery.change']);
Route::get('survey/{id}', ['uses' => 'ModernSlaverySupplierController@getSupplierSurvey', 'as' => 'modernslavery.survey']);
Route::post('survey/{id}', ['uses' => 'ModernSlaverySupplierController@saveSupplierSurvey', 'as' => 'survey.save']);
Route::get('report/{id}', ['uses' => 'ModernSlaveryController@showReport', 'as' => 'modernslavery.report']);
Route::get('customer_survey/{id}', ['uses' => 'ModernSlaveryController@getCustomerSurvey', 'as' => 'customer.survey']);
Route::post('customer_survey/{id}', ['uses' => 'ModernSlaveryController@saveCustomerSurvey', 'as' => 'cusurvey.save']);
Route::get('customer_survey', ['uses' => 'ModernSlaveryController@getCustomerSurveyResults', 'as' => 'survey.results']);

//Microsite routes
Route::resource('microsite', 'MicrositeController');
Route::resource('microbids', 'MicrobidsController');
Route::get('microsite_users', ['uses' => 'MicrositeController@viewUsers', 'as'=>'microsite.users']);
Route::get('addresult/{id}', ['uses' =>'MicrositeController@addResult', 'as' => 'microsite.addresult']);
Route::post('updateresult/{id}', ['uses' => 'MicrositeController@updateResult', 'as' => 'microsite.updateresult']);
Route::get('overview/{id}', ['uses' => 'MicrositeController@showOverview', 'as' => 'microsite.overview']);
Route::get('sentiment/{id}', ['uses' => 'MicrositeController@showSentiment', 'as' => 'microsite.sentiment']);
Route::get('entries/{id}', ['uses' => 'MicrositeController@showAll', 'as' => 'microsite.entries']);
Route::get('viewbids/{id}', ['uses' => 'MicrobidsController@viewBids', 'as' => 'microbids.bids']);
Route::post('addResult/{id}', ['uses' => 'MicrobidsController@addResult', 'as' => 'microbids.result']);

//Frontend Routes
Route::resource('home', 'FrontendController');
Route::get('about', ['uses'=>'FrontendController@showAbout', 'as'=>'frontend.about']);
Route::get('partners', ['uses'=>'FrontendController@showPartners', 'as'=>'frontend.partners']);
Route::get('legal', ['uses'=>'FrontendController@showLegal', 'as'=>'frontend.legal']);
Route::get('services', ['uses'=>'FrontendController@showServices', 'as'=>'frontend.services']);
Route::get('seratio', ['uses'=>'FrontendController@showSeratio', 'as'=>'frontend.seratio']);
Route::get('contact', ['uses'=>'FrontendController@showContact', 'as'=>'frontend.contact']);
Route::get('personalvalue', ['uses'=>'FrontendController@showPV', 'as'=>'frontend.pv']);
Route::get('pv', ['uses'=>'FrontendController@showPersonal', 'as'=>'frontend.personal']);
Route::get('team', ['uses'=>'FrontendController@showTeam', 'as'=>'frontend.team']);
Route::get('feedbacks', ['uses'=>'FrontendController@showFeedback', 'as'=>'frontend.feedback']);
Route::post('contactus',['uses' => 'FrontendController@getContactUsForm', 'as'=> 'frontend.contactus']);


Route::get('getFinancialYear/{id}',['uses'=>'WmfsSupplierController@getFinancialYear', 'as'=>'customer.financial_year']);

Route::get('getFinancialYearforBidder/{id}',['uses'=>'WmfsbiddersController@getFinancialYear', 'as'=>'customer_bidder.financial_year']);
