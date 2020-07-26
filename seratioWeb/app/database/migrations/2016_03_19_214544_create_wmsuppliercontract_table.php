<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWmsuppliercontractTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wmcuscontracts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('user_id');
			$table->string('public_sector_organisation');
			$table->string('contract_name');
			$table->string('contract_value');
			$table->string('contract_reference');
			$table->dateTime('date_start');
			$table->string('contract_length');
			$table->dateTime('end_date');
			$table->string('social_impact_min');
			$table->string('social_value_target');
			$table->string('kpi_organisation');
			$table->string('cash_target');
			$table->string('cash_imp');
			$table->string('people_target');
			$table->string('people_imp');
			$table->string('environment_target');
			$table->string('environment_imp');
			$table->string('hyperlocality_target');
			$table->string('hyperlocality_imp');
			$table->string('other');
			$table->string('other_imp');
			$table->string('guidelines');

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
		Schema::drop('wmcuscontracts');
	}

}
