<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNameOfInitiativeToWmfscontractbids extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('wmfscontractbids', function($table)
		{
			$table->string('name_of_initiative')->nullable();
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
			$table->dropColumn('name_of_initiative');
		});
	}

}
