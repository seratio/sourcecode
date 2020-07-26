<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSentimentQ1SubToMscustomers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('mscustomers', function($table)
		{
			$table->string('sentiment_q1_sub')->nullable();

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('mscustomers', function($table)
		{
			$table->dropColumn('sentiment_q1_sub');
			
			
		});
	}

}
