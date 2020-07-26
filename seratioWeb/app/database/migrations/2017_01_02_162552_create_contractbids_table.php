<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractbidsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wmconbiddersbids', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->integer('contract_id')->unsigned();
			$table->string('bid_value')->nullable();
			$table->string('sv_investment')->nullable();
			$table->string('initiative')->nullable();
			$table->string('cost')->nullable();
			$table->string('people')->nullable();
			$table->string('positive')->nullable();
			$table->string('neutral')->nullable();
			$table->string('negative')->nullable();
			$table->string('environment')->nullable();
			$table->string('hyperlocality')->nullable();

			$table->timestamps();

			$table->foreign('user_id')
				->references('id')
				->on('users')
				->onDelete('cascade');

			$table->foreign('contract_id')
				->references('id')
				->on('wmcuscontracts')
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
		Schema::drop('wmconbiddersbids');
	}

}
