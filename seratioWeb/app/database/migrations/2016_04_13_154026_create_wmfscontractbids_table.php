<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWmfscontractbidsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wmfscontractbids', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('user_id');
			$table->string('supplier_id');
			$table->string ('contract_id');
			$table->string('cash')->nullable();
			$table->string('ev_cash')->nullable();
			$table->string('people')->nullable();
			$table->string('ev_people')->nullable();
			$table->string('environment')->nullable();
			$table->string('ev_environment')->nullable();
			$table->string('hyperlocality')->nullable();
			$table->string('ev_hyperlocality')->nullable();
			$table->string('sentiment')->nullable();
			$table->string('ev_sentiment')->nullable();
			$table->string('other')->nullable();
			$table->string('ev_other')->nullable();
			
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
		Schema::drop('wmfscontractbids');
	}

}
