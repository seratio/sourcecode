<?php

class Pvalue extends Eloquent {


	  public function feedbacks() {
	 	return $this->hasMany('Feedback');
	 }

	 public static function personalValue($user_id) {
	 	
	 	$results = Pvalue::with('feedbacks')->where('user_id', $user_id)->get();

		return $results;
	}

	 public static function quickPV($user_id) {
	 	
	 	$results = Pvalue::where('user_id', $user_id)->first();

		return $results;
	}
}