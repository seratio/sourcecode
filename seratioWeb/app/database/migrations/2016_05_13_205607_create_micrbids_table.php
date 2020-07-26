<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMicrbidsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('microbids', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('user_id');
			$table->string('microsite_id');
			$table->string('bid_name')->nullable();
			$table->dateTime('bid_date')->nullable();
			$table->string('tender_number')->nullable();
			$table->string('price')->nullable();
			$table->string('added_social_value')->nullable();
			$table->string('people')->nullable();
			$table->string('cash')->nullable();
			$table->string('environment')->nullable();

			$table->string('annual_price')->nullable();
			$table->string('social_value')->nullable();
			$table->string('total')->string();

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
		Schema::drop('microbids');
	}

}
