<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNoOfMonthsWmcontractbids extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('wmfscontractbids', function($table)
		{
			$table->string('no_of_months')->nullable();
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
			$table->dropColumn('no_of_months');
		});
	}

}
