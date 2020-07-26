<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocialvaluesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('socialvalues', function(Blueprint $table)
		{
			$table->increments('id');
            $table->dateTime('sentiment_date');
            $table->double('positive');
            $table->double('neutral');
            $table->double('negative');
            $table->double('csr');
            $table->double('deg_of_separation');
            $table->double('shares');
            $table->double('capititilization_NAV');
            $table->double('staff');
            $table->double('carbon_reduction_t');
            $table->double('carbon_offset');
            $table->double('value_tCO2e_non_traded');
            $table->double('value_tCO2e_traded');
            $table->double('people');
            $table->double('money_leveraged');
            $table->double('current_year_directors_salary_executive');
            $table->double('current_year_directors_salary_non_executive');
            $table->double('current_year_staff_salary');
            $table->double('current_year_staff_salary_without_directors');
            $table->double('current_year_tax_charged');
            $table->double('current_year_total_share_holder_pay_dividend_cash');
            $table->double('current_year_executive_board');
            $table->double('current_year_non_executive_board');
            $table->double('current_year_board_total');
            $table->double('current_year_number_of_staffs');
            $table->double('prior_year_directors_salary_executive');
            $table->double('prior_year_directors_salary_non_executive');
            $table->double('prior_year_staff_salary');
            $table->double('prior_year_staff_salary_without_directors');
            $table->double('prior_year_tax_charged');
            $table->double('prior_year_total_share_holder_pay_dividend_cash');
            $table->double('prior_year_executive_board');
            $table->double('prior_year_non_executive_board');
            $table->double('prior_year_board_total');
            $table->double('prior_year_number_of_staffs');
            $table->softDeletes();
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
		Schema::drop('socialvalues');
	}

}
