<?php

class Modernslavery extends Eloquent {

	 // public function user() {
	 // 	return $this->belongsTo('user', 'user_id');
	 // }

   public static $YEAR = ["None" 	=> "Please select the year",
                          "2018" 	=> '2018',
                          "2017"	=> '2017',
                          "2016" 	=> "2016",
                          "2015" 	=> "2015",
                          "2014" 	=> "2014",
                          "2013" 	=> "2013",
                          "2012" 	=> "2012"
                        ];

  public static $WAGE = ["2018" 	=> '7.83',
                         "2017"	  => '7.50',
                         "2016" 	=> "7.20",
                         "2015" 	=> "6.70",
                         "2014" 	=> "6.50",
                         "2013" 	=> "6.31",
                         "2012" 	=> "6.19"
                       ];

}
