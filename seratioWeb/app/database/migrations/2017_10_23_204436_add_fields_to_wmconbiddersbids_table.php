<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToWmconbiddersbidsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('wmconbiddersbids', function(Blueprint $table)
		{
			$table->string('n_positive')->nullable();
			$table->string('n_negative')->nullable();
			$table->string('n_neutral')->nullable();

			$table->string('a_positive')->nullable();
			$table->string('a_negative')->nullable();
			$table->string('a_neutral')->nullable();

			$table->string('ser')->nullable();
			$table->string('social_impact')->nullable();
			$table->string('social_impact_asap_cap')->nullable();
			$table->string('added_value')->nullable();
			$table->string('environment_r')->nullable();
			$table->string('people_r')->nullable();
			$table->string('cash_r')->nullable();
			$table->string('distance')->nullable();

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
		Schema::table('wmconbiddersbids', function(Blueprint $table)
		{
			$table->dropColumn('n_positive');
			$table->dropColumn('n_negative');
			$table->dropColumn('n_neutral');

			$table->dropColumn('a_positive');
			$table->dropColumn('a_negative');
			$table->dropColumn('a_neutral');

			$table->dropColumn('ser');
			$table->dropColumn('social_impact');
			$table->dropColumn('social_impact_asap_cap');
			$table->dropColumn('added_value');
			$table->dropColumn('environment_r');
			$table->dropColumn('people_r');
			$table->dropColumn('cash_r');
			$table->dropColumn('distance');

			$table->dropColumn('cash_gen_invested');
			$table->dropColumn('people_cal');
			$table->dropColumn('enviornment_cal');

		});
	}

}
