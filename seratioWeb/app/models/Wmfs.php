<?php

class Wmfs extends Eloquent {


	protected $fillable = [
			'measured_year','targeted_audience','positive', 'neutral', 'negative', 'margin_errors', 'target_population', 'sentiment_date',
			'non_statutory_spend', 'no_of_service_users', 'net_asset_value', 'staff',
			'carbon_reduction_t', 'carbon_offset','people', 'money_leveraged', 'cu_directors_salary',
			'cu_members_salary', 'cu_staff_salary_bill', 'cu_executive_board',
			'cu_total_counc_members', 'cu_total_board_senior_directors',
			'cu_total_staff','py_directors_salary', 'py_members_salary',
			'py_staff_salary_bill', 'py_executive_board','py_total_counc_members',
			'py_total_board_senior_directors', 'py_total_staff',
			'user_id', 'save_type', 'role_id'
	];

	 public function user() {
	 	return $this->belongsTo('user');
	 }

	 public function contracts() {

	 	return $this->hasMany('Wmcuscontract');
	 }

}
