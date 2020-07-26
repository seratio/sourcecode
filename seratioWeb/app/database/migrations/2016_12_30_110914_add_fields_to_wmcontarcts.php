<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToWmcontarcts extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('wmcuscontracts', function($table)
		{
			$table->string('sv_perc_final')->nullable();
			$table->string('sv_perc_expectations')->nullable();
			$table->string('sv_ambitions_of_authority')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('wmcuscontracts', function($table)
		{
			$table->dropColumn('sv_perc_final');
			$table->dropColumn('sv_perc_expectations');
			$table->dropColumn('sv_ambitions_of_authority');
		});
	}

}
