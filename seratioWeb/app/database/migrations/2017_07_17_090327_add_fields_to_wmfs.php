<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToWmfs extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('wmfs', function($table)
		{
			$table->string('environment_eq')->nullable();
			$table->string('people_eq')->nullable();
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
		Schema::table('wmfs', function($table)
		{
			$table->dropColumn('environment_eq');
			$table->dropColumn('people_eq');
			$table->dropColumn('cash_gen_invested');
			$table->dropColumn('people_cal');
			$table->dropColumn('enviornment_cal');
		});
	}

}
