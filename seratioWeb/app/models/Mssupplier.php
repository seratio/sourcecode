<?php

class Mssupplier extends Eloquent {

	 protected $table = 'mssuppliers';

	 protected $fillable = [
			'customer_id','customer_number','user_id', 'supplier_name', 'number_street', 'city', 'county', 
			'post_code', 'country', 'email', 'sector', 'main_industry', 'currency', 'total_revenue', 'total_wages',
			'no_of_employees','sentiment_q1', 'sentiment_q2', 'sentiment_q3', 'document1', 
			'document2', 'document3', 'document4', 'document5'
	];

	public function customer() {

		return $this->belongsTo('Mscustomer');
	}

	 public function suppliers() {

	 	return $this->hasMany('Mssurvey');
	 }



}