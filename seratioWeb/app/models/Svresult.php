<?php

class Svresult extends Eloquent {
	use SoftDeletingTrait;

	 public function socialvalue() {
	 	return $this->belongsTo('socialvalue', 'socialvalue_id');
	 }
}