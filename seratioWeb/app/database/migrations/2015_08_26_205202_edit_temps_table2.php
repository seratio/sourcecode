<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditTempsTable2 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('temps', function($table)
		{
			$table->string('name')->nullable();
			$table->string('comment')->nullable;
			
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
			$table->dropColumns('name');
			$table->dropColumns('comment');
			
		});
	}

}
