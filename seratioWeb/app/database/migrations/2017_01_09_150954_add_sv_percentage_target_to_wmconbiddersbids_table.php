<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSvPercentageTargetToWmconbiddersbidsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('wmconbiddersbids', function($table)
		{
			$table->string('sv_percentage_of_target')->nullable();
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
			$table->dropColumn('sv_percentage_of_target');
		});
	}

}
