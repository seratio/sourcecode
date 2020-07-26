<?php

class Wmcontractbid extends Eloquent {

	 protected $table = 'wmfscontractbids';


	 public function contract() {
	 	
	 	return $this->belongsTo('Wmcuscontract');
	 }


}