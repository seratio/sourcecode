<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBlockchainsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('blockchains', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('email', 512);
			$table->string('country');
			$table->double('family');
			$table->double('worth');
			$table->double('carbon_reduction');
			$table->double('csr');
			$table->double('people');
			$table->double('money_leveraged');
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
		Schema::drop('blockchains');
	}

}
