<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnvironmentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('environments', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('high');
			$table->string('good');
			$table->string('avg');
			$table->string('poor');
			$table->string('low');
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
		Schema::drop('environments');
	}

}
