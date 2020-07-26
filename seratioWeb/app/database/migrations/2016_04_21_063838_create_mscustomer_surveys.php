<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMscustomerSurveys extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mscustomersurveys', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('customer_id')->unsigned();
			$table->string('customer_number')->nullable();
			$table->string('country')->nullable();
			$table->string('question_1')->nullable();
			$table->string('question_2')->nullable();
			$table->string('question_3')->nullable();
			$table->string('question_4')->nullable();
			$table->string('question_5')->nullable();
			$table->string('question_6')->nullable();
			$table->string('question_7')->nullable();
			$table->string('question_8')->nullable();
			$table->string('question_9')->nullable();
			$table->string('question_10')->nullable();
			$table->string('survey_type')->nullable();

			
		
			$table->timestamps();
			$table->foreign('customer_id')
				->references('id')
				->on('mscustomers')
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
		Schema::drop('mscustomersurveys');
	}

}
