<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSentimentQ4ToMssuppliers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('mssuppliers', function($table)
			{
				$table->string('sentiment_q4')->nullable();
			});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('mssuppliers', function($table)
			{
				$table->dropColumn('sentiment_q4');
				
			});
	}

}
