<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddValuesSocialvalues extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('socialvalues', function($table)
		{
			$table->double('ser');
			$table->double('social_impact');
			$table->double('social_impact_asap_cap');
			$table->double('added_value');
			$table->double('environment');
			$table->double('people_r');
			$table->double('cash');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('socialvalues', function($table)
		{
			$table->dropColumn('ser');
			$table->dropColumn('social_impact');
			$table->dropColumn('social_impact_asap_cap');
			$table->dropColumn('added_value');
			$table->dropColumn('environment');
			$table->dropColumn('people_r');
			$table->dropColumn('cash');
		});
	}

}
