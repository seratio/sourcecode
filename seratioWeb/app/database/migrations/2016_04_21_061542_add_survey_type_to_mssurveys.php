<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSurveyTypeToMssurveys extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('mssurveys', function($table)
		{
			$table->string('survey_type')->nullable();
			
			

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
			$table->dropColumn('survey_type');
			
			
		});
	}

}
