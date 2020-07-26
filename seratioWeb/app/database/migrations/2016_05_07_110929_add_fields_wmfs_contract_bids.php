<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsWmfsContractBids extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('wmfscontractbids', function($table)
		{
			$table->string('ev_cash_url')->nullable();
			$table->string('ev_people_url')->nullable();
			$table->string('ev_environment_url')->nullable();
			$table->string('ev_hyperlocality_url')->nullable();
			$table->string('ev_sentiment_url')->nullable();
			$table->string('ev_other_url')->nullable();	

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('wmfscontractbids', function($table)
		{
			$table->dropColumn('ev_cash_url');
			$table->dropColumn('ev_people_url');
			$table->dropColumn('ev_environment_url');
			$table->dropColumn('ev_hyperlocality_url');
			$table->dropColumn('ev_sentiment_url');
			$table->dropColumn('ev_other_url');	
		});
	}

}
