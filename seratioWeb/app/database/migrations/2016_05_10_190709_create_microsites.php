<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMicrosites extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('microsites', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('user_id');
			$table->string('customer_type');
			$table->string('customer_name')->nullable();
			$table->string('number_street')->nullable();
			$table->string('city')->nullable();
			$table->string('county')->nullable();
			$table->string('post_code')->nullable();
			$table->string('country')->nullable();
			$table->string('primary_contact')->nullable();
			$table->string('number')->nullable();
			$table->string('email')->nullable();
			$table->string('audited_accounts')->nullable();
			$table->string('published_accounts')->nullable();
			$table->string('free_text')->nullable();
			$table->string('question1')->nullable();
			$table->string('question2')->nullable();
			$table->string('question3')->nullable();
			$table->string('question4')->nullable();
			$table->string('question5')->nullable();
			
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
		Schema::drop('microsites');
	}

}
