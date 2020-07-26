<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFreeTextInMscustomers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('mscustomers', function($table)
		{
			
			$table->string('free_text')->nullable();
			$table->dropColumn('checkbox4');
			

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('mscustomers', function($table)
		{
			
			$table->dropColumn('free_text');
			$table->string('checkbox4')->nullable();

		});
	}

}
