<?php

class Mscustomersurvey extends Eloquent {

	 protected $table = 'mscustomersurveys';

	public function customer() {

		return $this->belongsTo('Mscustomersurvey');
	}

	

}