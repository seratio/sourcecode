<?php

class Microbid extends Eloquent {

	 protected $table = 'microbids';

	 public function user() {
	      return $this->belongsTo('User');
	   }
}