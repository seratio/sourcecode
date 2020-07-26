<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEusTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('eus', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('fiware');
			$table->string('capitalisation');
			$table->string('staff');
			$table->string('shares');
			$table->string('csr');
			$table->string('people');
			$table->string('sentiment');
			$table->string('environment');
			$table->string('user_id');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('eus');
	}

}
