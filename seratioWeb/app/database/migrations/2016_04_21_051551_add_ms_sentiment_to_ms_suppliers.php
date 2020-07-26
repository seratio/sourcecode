<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMsSentimentToMsSuppliers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('mssuppliers', function($table)
			{
				$table->string('modern_slavery')->nullable();
				$table->string('sentiment')->nullable();
				

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
				$table->dropColumn('modern_slavery');
				$table->dropColumn('sentiment');
				
			});
	}

}
