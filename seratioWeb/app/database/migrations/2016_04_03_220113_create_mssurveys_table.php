<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMssurveysTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mssurveys', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('supplier_number');
			$table->string('customer_number');
			$table->string('country');
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
		Schema::drop('mssurveys');
	}

}
