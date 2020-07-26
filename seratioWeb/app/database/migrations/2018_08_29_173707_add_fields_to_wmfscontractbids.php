<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToWmfscontractbids extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('wmfscontractbids', function(Blueprint $table)
		{
			$table->string('positive')->nullable();
			$table->string('negative')->nullable();
			$table->string('neutral')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('wmfscontractbids', function(Blueprint $table)
		{
			$table->dropColumn('positive');
			$table->dropColumn('negative');
			$table->dropColumn('neutral');
		});
	}

}
