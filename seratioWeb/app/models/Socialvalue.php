<?php

class Socialvalue extends Eloquent {
	use SoftDeletingTrait;

	protected $fillable = [
			'positive', 'neutral', 'negative', 'sentiment_date',
			'csr', 'deg_of_separation', 'shares', 'capititilization_NAV', 'staff',
			'carbon_reduction_t', 'carbon_offset', 'value_tCO2e_non_traded', 'value_tCO2e_traded',
			'people', 'money_leveraged', 'current_year_directors_salary_executive', 
			'current_year_directors_salary_non_executive', 'current_year_staff_salary',
			'current_year_staff_salary_without_directors', 'current_year_tax_charged',
			'current_year_total_share_holder_pay_dividend_cash', 'current_year_executive_board',
			'current_year_non_executive_board', 'current_year_board_total', 'current_year_number_of_staffs',
			'prior_year_directors_salary_executive', 'prior_year_directors_salary_non_executive',
			'prior_year_staff_salary', 'prior_year_staff_salary_without_directors','prior_year_tax_charged',
			'prior_year_total_share_holder_pay_dividend_cash', 'prior_year_executive_board', 'prior_year_non_executive_board', 
			'prior_year_board_total', 'prior_year_number_of_staffs', 'user_id'
	];

	 public function svresult() {
	 	return $this->hasMany('svresult');
	 }

	 public function user() {
	 	return $this->belongsTo('user');
	 }
}