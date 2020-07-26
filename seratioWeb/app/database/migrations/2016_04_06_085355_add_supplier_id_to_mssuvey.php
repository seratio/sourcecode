<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSupplierIdToMssuvey extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('mssurveys', function($table)
			{
				$table->integer('supplier_id')->unsigned();

				$table->foreign('supplier_id')
				->references('id')
				->on('mssuppliers')
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
		Schema::table('mssurveys', function($table)
			{
				$table->dropColumn('supplier_id');
				
			});
	}

}
