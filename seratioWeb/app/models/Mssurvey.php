<?php

class Mssurvey extends Eloquent {

	 protected $table = 'mssurveys';

	public function supplier() {

		return $this->belongsTo('Mssurvey');
	}

	

}