<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsInTempsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('temps', function($table)
		{
			$table->string('question7')->nullable();
			$table->string('question8')->nullable();
			$table->string('question9')->nullable();
			
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
			$table->dropColumn('question7');
			$table->dropColumn('question8');
			$table->dropColumn('question9');
			
		});
	}

}
