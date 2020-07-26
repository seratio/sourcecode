<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSapimsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sapims', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('email', 512);
			$table->string('financial_year');
			$table->string('total_salary');
			$table->string('total_staff');
			$table->string('sentiment');
			$table->string('result');

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
		Schema::drop('sapims');
	}

}
