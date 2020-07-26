<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplierInfo extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wmsuppliers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('user_id');
			$table->string('supplier_name');
			$table->string('number_street');
			$table->string('city');
			$table->string('county');
			$table->string('post_code');
			$table->string('country');
			$table->string('supplier_authorised_individuals');
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
		Schema::drop('wmsuppliers');
	}

}
