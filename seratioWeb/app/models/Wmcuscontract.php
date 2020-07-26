<?php

class Wmcuscontract extends Eloquent {

	 protected $table = 'wmcuscontracts';

	 protected $fillable = [
			'user_id', 'role_id', 'public_sector_organisation', 'contract_name', 'contract_value',
			'contract_reference', 'date_start', 'contract_length',
			'social_impact_min', 'social_value_target', 'cash_target', 'cash_imp',
			'people_target', 'people_imp', 'environment_target', 'environment_imp', 'hyperlocality_target', 'hyperlocality_imp',
			'other', 'other_imp', 'guidelines'
	];

	 public function customer() {

	 	return $this->belongsTo('Wmfs');
	 }


	public function bids() {

		return $this->hasMany('Wmcontractbid', 'contract_id');
	}

	public static function forSelect() {
		$contracts = self::get();
		$retContracts = array();
		$retContracts[-1] = "-- Please Select --";
		foreach ($contracts as $contract) {
			$retContracts[$contract->id] = $contract->contract_name;
		}
		asort($retContracts);

		return $retContracts;
	}


}
