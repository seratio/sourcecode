<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableWmconsuppls extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wmconsuppls', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('contract_id')->unsigned();
			$table->integer('supplier_id')->unsigned();
			$table->timestamps();

			$table->foreign('contract_id')
				->references('id')
				->on('wmcuscontracts')
				->onDelete('cascade');

			$table->foreign('supplier_id')
				->references('id')
				->on('wmsuppliers')
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
		Schema::drop('wmconsuppls');
	}

}
