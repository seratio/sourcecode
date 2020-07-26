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
			$table->string('original_postive')->nullable();
			$table->string('original_negative')->nullable();
			$table->string('original_neutral')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('wmconbidders', function($table)
		{
			$table->dropColumn('original_postive');
			$table->dropColumn('original_negative');
			$table->dropColumn('original_neutral');
		});
	}

}
