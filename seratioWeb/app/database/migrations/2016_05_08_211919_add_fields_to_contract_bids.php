<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToContractBids extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		Schema::table('wmfscontractbids', function($table)
		{
			$table->string('total_social_value')->nullable();
			$table->string('social_value_min_perc')->nullable();
			$table->string('social_value_hun_perc')->nullable();
			$table->string('social_value_forecast')->nullable();

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
			$table->dropColumn('total_social_value');
			$table->dropColumn('social_value_min_perc');
			$table->dropColumn('social_value_hun_perc');
			$table->dropColumn('social_value_forecast');
		});
	}

}
