<?php

class Wmconbiddersbid extends Eloquent {

	protected $table = 'wmconbiddersbids';


	 public function contract() {
	 	return $this->belongsTo('Wmcuscontract');
	 }

	 public function user() {
	 	return $this->belongsTo('User');
	 }


}
