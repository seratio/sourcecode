<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMscustomers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mscustomers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('user_id');
			$table->string('customer_name')->nullable();
			$table->string('number_street')->nullable();
			$table->string('city')->nullable();
			$table->string('county')->nullable();
			$table->string('post_code')->nullable();
			$table->string('country')->nullable();
			$table->string('primary_contact')->nullable();
			$table->string('number')->nullable();
			$table->string('email')->nullable();
			$table->string('sector')->nullable();
			$table->string('main_industry')->nullable();
			$table->string('currency')->nullable();
			$table->string('total_revenue')->nullable();
			$table->string('total_wages')->nullable();
			$table->string('no_of_employees')->nullable();
			$table->string('no_of_pt_employees')->nullable();
			$table->string('total_pt_hours')->nullable();
			$table->string('total_pt_wages')->nullable();
			$table->string('document1')->nullable();
			$table->string('document2')->nullable();
			$table->string('document3')->nullable();
			$table->string('document4')->nullable();
			$table->string('document5')->nullable();
			$table->string('sentiment_q1')->nullable();
			$table->string('sentiment_q2')->nullable();
			$table->string('sentiment_q3')->nullable();
			$table->string('sentiment_q4')->nullable();

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
		Schema::drop('mscustomers');
	}

}
