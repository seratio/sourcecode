<?php

class Wmsupplier extends Eloquent {

	 protected $table = 'wmsuppliers';

	 protected $fillable = [
			'user_id', 'supplier_name', 'number_street', 
			'city', 'county', 'post_code', 'country', 
			'supplier_authorised_individuals'
	];

	public static function forSelect() {
		$suppliers = self::get();
		$retSuppliers = array();
		$retCustomers[-1] = "-- Please Select --";
		foreach ($suppliers as $supplier) {
			$retSuppliers[$supplier->id] = $supplier->supplier_name;
		}
		asort($retSuppliers);

		return $retSuppliers;
	}


}