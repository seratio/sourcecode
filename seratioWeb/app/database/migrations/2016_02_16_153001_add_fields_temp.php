<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsTemp extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('temps', function($table)
		{
			$table->string('fiware');
			$table->string('capitalisation');
			$table->string('staff');
			$table->string('shares');
			$table->string('csr');
			$table->string('people');
			$table->string('sentiment');
			$table->string('environment');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('temps', function($table)
		{
			$table->dropColumn('fiware');
			$table->dropColumn('capitalisation');
			$table->dropColumn('staff');
			$table->dropColumn('shares');
			$table->dropColumn('csr');
			$table->dropColumn('people');
			$table->dropColumn('sentiment');
			$table->dropColumn('environment');
			
		});
	}

}
