<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWmtendersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wmtenders', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->string('contract_name')->nullable();
			$table->string('estimated_price')->nullable();
			$table->string('tender')->nullable();
			$table->string('social_value_act')->nullable();
			$table->string('modern_slavery_act')->nullable();
			$table->string('contract_value')->nullable();
			$table->string('added_social_value')->nullable();
			$table->string('people')->nullable();
			$table->string('cash')->nullable();
			$table->string('environment')->nullable();
			$table->string('hyperlocality')->nullable();
			$table->string('pay_disparity')->nullable();
			$table->string('tax_avoidance')->nullable();
			$table->string('sv_as_perc_contract_value')->nullable();
			$table->string('kpi1')->nullable();
			$table->string('kpi2')->nullable();
			$table->string('final_score')->nullable();
			$table->string('price_scoring')->nullable();
			$table->string('quality_scoring')->nullable();
			$table->string('social_value_scoring')->nullable();

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
		Schema::drop('wmtenders');
	}

}
