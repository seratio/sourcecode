<?php

class Wmconsuppl extends Eloquent {
	
	protected $table = 'wmconsuppls';

	
	 public function contract() {
	 	return $this->belongsTo('Wmcuscontract');
	 }

	 public function supplier() {
	 	return $this->belongsTo('Wmsupplier');
	 }


}