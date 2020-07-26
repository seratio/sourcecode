<?php

class Wmtender extends Eloquent {
	
	protected $table = 'wmtenders';

	 protected $fillable = [
			'user_id', 'contract_name', 'estimated_price', 'tender','social_value_act',
		'modern_slavery_act', 'contract_value', 'added_social_value', 'people', 'cash', 'environment', 'hyperlocality', 'pay_disparity',
		'tax_avoidance', 'sv_as_perc_contract_value', 'kpi1', 'kpi2', 'final_score', 'price_scoring',
		'quality_scoring', 'social_value_scoring'
	];

	 public function user() {
	 	return $this->belongsTo('user');
	 }


}