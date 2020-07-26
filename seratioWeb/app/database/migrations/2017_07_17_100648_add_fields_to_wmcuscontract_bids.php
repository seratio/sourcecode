<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToWmcuscontractBids extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('wmfscontractbids', function($table)
		{
			$table->string('cash_gen_invested')->nullable();
			$table->string('people_cal')->nullable();
			$table->string('enviornment_cal')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('wmfscontractbids', function($table)
		{
			$table->dropColumn('cash_gen_invested');
			$table->dropColumn('people_cal');
			$table->dropColumn('enviornment_cal');
		});
	}

}
