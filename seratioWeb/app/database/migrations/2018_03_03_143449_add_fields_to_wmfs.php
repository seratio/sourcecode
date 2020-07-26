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
		Schema::table('wmfs', function(Blueprint $table)
		{
			$table->string('margin_errors')->nullable();
			$table->string('target_population')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('wmfs', function(Blueprint $table)
		{
			$table->dropColumn('margin_errors');
			$table->dropColumn('target_population');
		});
	}

}
