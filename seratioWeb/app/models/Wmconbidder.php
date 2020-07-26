<?php

class Wmconbidder extends Eloquent {

	protected $table = 'wmconbidders';


	 public function contract() {
	 	return $this->belongsTo('Wmcuscontract');
	 }

	 public function user() {
	 	return $this->belongsTo('User');
	 }


}
