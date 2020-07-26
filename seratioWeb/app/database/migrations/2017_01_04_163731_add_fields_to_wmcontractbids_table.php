<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToWmcontractbidsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('wmconbiddersbids', function($table)
		{
			$table->string('added_sv')->nullable();
			$table->string('added_sv_financial_sum')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('wmconbiddersbids', function($table)
		{
			$table->dropColumn('added_sv');
			$table->dropColumn('added_sv_financial_sum');
		});
	}

}
