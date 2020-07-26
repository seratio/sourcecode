<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMicrosvalues extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('microsvalues', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('user_id');
			$table->string('microsite_id');
			$table->string('targeted_audience')->nullable();
			$table->dateTime('sentiment_date')->nullable();
			$table->string('positive')->nullable();
			$table->string('neutral')->nullable();
			$table->string('negative')->nullable();

			$table->string('non_statutory_spend')->nullable; 
			$table->string('no_of_service_users')->nullable; 
			$table->string('net_asset_value')->nullable();
			$table->string('staff')->nullable();
			$table->string('carbon_reduction_t')->nullable();
			$table->string('carbon_offset')->nullable();
			$table->string('people')->nullable();
			$table->string('money_leveraged')->nullable();
			$table->string('cu_directors_salary')->nullable(); 
			$table->string('cu_members_salary')->nullable(); 
			$table->string('cu_staff_salary_bill')->nullable();
			$table->string('cu_executive_board')->nullable();
			$table->string('cu_total_counc_members')->nullable();
			$table->string('cu_total_board_senior_directors')->nullable();
			$table->string('cu_total_staff')->nullable();
			$table->string('py_directors_salary')->nullable(); 
			$table->string('py_members_salary')->nullable(); 
			$table->string('py_staff_salary_bill')->nullable();
			$table->string('py_executive_board')->nullable();
			$table->string('py_total_counc_members')->nullable();
			$table->string('py_total_board_senior_directors')->nullable();
			$table->string('py_total_staff')->nullable();
			$table->string('ser')->nullable();
			$table->string('social_impact')->nullable();
			$table->string('social_impact_asap_cap');
			$table->string('added_value')->nullable();

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
		Schema::drop('microsvalues');
	}

}
