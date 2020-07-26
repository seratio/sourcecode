<?php

class Mscustomer extends Eloquent {

	 protected $table = 'mscustomers';

	 protected $fillable = [
			'user_id', 'customer_name', 'number_street', 'city', 'county', 
			'post_code', 'country', 'primary_contact', 'number', 'email', 
			'sector', 'main_industry', 'currency', 'total_revenue', 'total_wages',
			'no_of_employees', 'no_of_pt_employees', 'total_pt_hours', 'total_pt_wages',
			'sentiment_q1', 'sentiment_q2', 'sentiment_q3', 'sentiment_q4', 'document1', 
			'document2', 'document3', 'document4', 'document5'
	];

	 public function user() {
	      return $this->belongsTo('User');
	   }

	 public function suppliers() {

	 	return $this->hasMany('Mssupplier');
	 }

	  public function customers() {

	 	return $this->hasMany('Mscustomersurvey');
	 }

}