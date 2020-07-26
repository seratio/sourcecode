<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRoleIdPvaluesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('pvalues', function($table)
		{
			$table->integer('user_id')->unsigned();

			$table->foreign('user_id')
				->references('id')
				->on('users')
				->onDelete('cascade');
			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('pvalues', function($table)
		{
			$table->dropColumn('user_id');
		});
	}

}
