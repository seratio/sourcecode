<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonalValuesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pvalues', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('comment');
			$table->double('question1');
			$table->double('question2');
			$table->double('question3');
			$table->double('question4');
			$table->double('question5');
			$table->double('question6');
			$table->double('pv');
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
		Schema::drop('pvalues');
	}

}
