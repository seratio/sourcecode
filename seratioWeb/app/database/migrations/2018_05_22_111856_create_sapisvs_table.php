<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSapisvsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sapisvs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('email', 512);

			$table->string('positive');
			$table->string('neutral');
			$table->string('negative');
			$table->dateTime('sentiment_date');

			$table->string('non_statutory_spend');
			$table->string('no_of_service_users');
			$table->string('net_asset_value');
			$table->string('staff');

			$table->string('carbon_reduction_t');
			$table->string('carbon_offset');
			$table->string('people');
			$table->string('money_leveraged');

			$table->string('margin_errors')->nullable();
			$table->string('target_population')->nullable();

			$table->string('ser');
			$table->string('social_impact');
			$table->string('social_impact_asap_cap');
			$table->string('added_value');
			$table->string('environment');
			$table->string('people_r');
			$table->string('cash');

			$table->string('environment_eq')->nullable();
			$table->string('people_eq')->nullable();
			$table->string('cash_gen_invested')->nullable();
			$table->string('people_cal')->nullable();
			$table->string('enviornment_cal')->nullable();

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
		Schema::drop('sapisvs');
	}

}
