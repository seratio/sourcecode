<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToMssuppliers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
		{
			Schema::table('mssuppliers', function($table)
			{
				$table->string('customer_id');
				$table->string('customer_number');
				$table->string('supplier_another');
				$table->string('supplier_another_check');
			});
		}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
		{
			Schema::table('mssuppliers', function($table)
			{
				$table->dropColumn('customer_id');
				$table->dropColumn('customer_number');
				$table->dropColumn('supplier_another');
				$table->dropColumn('supplier_another_check');
				
			});
		}

}
