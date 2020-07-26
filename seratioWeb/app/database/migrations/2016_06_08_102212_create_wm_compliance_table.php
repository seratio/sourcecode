<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWmComplianceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wmcompliances', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();

			$table->string('compliance_rag')->nullable;

			$table->string('environment')->nullable();
			$table->string('environment_rag')->nullable();
			$table->string('cash')->nullable();
			$table->string('cash_rag')->nullable();
			$table->string('people')->nullable();
			$table->string('people_rag')->nullable();
			$table->string('tax_avoidance')->nullable();
			$table->string('tax_avoidance_rag')->nullable();
			$table->string('pay_disparity')->nullable();
			$table->string('pay_disparity_rag')->nullable();
			$table->string('personal_value')->nullable();
			$table->string('personal_value_rag')->nullable();
			$table->string('transpareny_in_supply_chain')->nullable();
			$table->string('transpareny_in_supply_chain_rag')->nullable();
			$table->string('sentiment')->nullable();
			$table->string('sentiment_rag')->nullable();
			$table->string('hyperlocality')->nullable();
			$table->string('hyperlocality_rag')->nullable();
			$table->string('forward_forecasting')->nullable();
			$table->string('forward_forecasting_rag')->nullable();
			$table->string('time_dependent_monitoring')->nullable();
			$table->string('time_dependent_monitoring_rag')->nullable();
			$table->string('financial_value')->nullable();
			$table->string('financial_value_rag')->nullable();
			$table->string('benchmarking')->nullable();
			$table->string('benchmarking_rag')->nullable();

			$table->string('social_value_act')->nullable();
			$table->string('social_value_act_rag')->nullable();
			$table->string('modern_slavery_act')->nullable();
			$table->string('modern_slavery_act_rag')->nullable();
			$table->string('iso26000')->nullable();
			$table->string('iso26000_rag')->nullable();
			$table->string('gri_4')->nullable();
			$table->string('gri4_rag')->nullable();
			$table->string('iirc')->nullable();
			$table->string('iirc_rag')->nullable();
			$table->string('benefit_coro')->nullable();
			$table->string('benefit_coro_rag')->nullable();
			$table->string('wef')->nullable();
			$table->string('wef_rag')->nullable();
			$table->string('wu_500_csr')->nullable();
			$table->string('wu_500_csr_rag')->nullable();
			$table->string('geces')->nullable();
			$table->string('geces_rag')->nullable();
			$table->string('si')->nullable();
			$table->string('si_rag')->nullable();
			$table->string('litigation_liability')->nullable();
			$table->string('litigation_liability_rag')->nullable();

			$table->string('monthly_reporting')->nullable();
			$table->string('monthly_reporting_rag')->nullable();
			$table->string('independent_arbitration')->nullable();
			$table->string('independent_arbitration_rag')->nullable();
			$table->string('dashboard_provision')->nullable();
			$table->string('dashboard_provision_rag')->nullable();
			$table->string('capacity_development_online')->nullable();
			$table->string('capacity_development_online_rag')->nullable();
			$table->string('capacity_development_face')->nullable();
			$table->string('capacity_development_face_rag')->nullable();
			$table->string('capacity_development_written')->nullable();
			$table->string('capacity_development_written_rag')->nullable();
			$table->string('engagement')->nullable();
			$table->string('engagement_rag')->nullable();
			$table->string('solutions')->nullable();
			$table->string('solutions_rag')->nullable();
			$table->string('ideation')->nullable();
			$table->string('ideation_rag')->nullable();

		
			$table->timestamps();

			$table->foreign('user_id')
				->references('id')
				->on('users')
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
		Schema::drop('wmcompliances');
	}

}
