<?php

class Wmcompliance extends Eloquent {
	
	protected $table = 'wmcompliances';

	
	 public function user() {
	 	return $this->belongsTo('user');
	 }


}