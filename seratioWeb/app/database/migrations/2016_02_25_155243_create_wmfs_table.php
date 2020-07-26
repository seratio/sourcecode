<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWmfsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wmfs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('user_id');
			$table->string('targeted_audience');
			$table->dateTime('sentiment_date');
			$table->string('positive');
			$table->string('neutral');
			$table->string('negative');

			$table->string('non_statutory_spend'); 
			$table->string('no_of_service_users'); 
			$table->string('net_asset_value');
			$table->string('staff');

			$table->string('carbon_reduction_t');
			$table->string('carbon_offset');

			$table->string('people');

			$table->string('money_leveraged');

			$table->string('cu_directors_salary'); 
			$table->string('cu_members_salary'); 
			$table->string('cu_staff_salary_bill');
			$table->string('cu_executive_board');
			$table->string('cu_total_counc_members');
			$table->string('cu_total_board_senior_directors');
			$table->string('cu_total_staff');

			$table->string('py_directors_salary'); 
			$table->string('py_members_salary'); 
			$table->string('py_staff_salary_bill');
			$table->string('py_executive_board');
			$table->string('py_total_counc_members');
			$table->string('py_total_board_senior_directors');
			$table->string('py_total_staff');

			$table->string('ser');
			$table->string('social_impact');
			$table->string('social_impact_asap_cap');
			$table->string('added_value');
			$table->string('environment');
			$table->string('people_r');
			$table->string('cash');
			$table->boolean('query');
			$table->string('save_type');
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
		Schema::drop('wmfs');
	}

}


