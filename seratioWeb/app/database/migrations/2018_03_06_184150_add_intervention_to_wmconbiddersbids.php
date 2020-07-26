<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInterventionToWmconbiddersbids extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('wmconbiddersbids', function(Blueprint $table)
		{
			$table->string('intervention_across_all_years')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('wmconbiddersbids', function(Blueprint $table)
		{
			$table->dropColumn('intervention_across_all_years');
		});
	}

}
