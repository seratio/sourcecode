<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModernslaveriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('modernslaveries', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->string('financial_year');
			$table->double('total_salary');
			$table->double('total_staff');
			$table->double('sentiment');
			$table->double('result');

			$table->timestamps();
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
		Schema::drop('modernslaveries');
	}

}
