<?php

class Microsite extends Eloquent {

	 protected $table = 'microsites';

	 public function user() {
	      return $this->belongsTo('User');
	   }

	 public function microvalue() {
	 	return $this->hasOne('Microvalue');
	 }
}