<?php

class Feedback extends Eloquent {

	 public function pvalue() {
	 	return $this->belongsTo('Pvalue', 'pvalue_id');
	 }
}