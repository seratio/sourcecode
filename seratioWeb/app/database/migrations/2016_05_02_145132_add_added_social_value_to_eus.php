<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAddedSocialValueToEus extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('eus', function($table)
		{
			$table->string('added_social_value')->nullable();	

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('eus', function($table)
		{
			$table->dropColumn('added_social_value');
		});
	}

}
