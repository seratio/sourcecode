<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatementFieldsToMscustomers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('mscustomers', function($table)
		{
			$table->string('nature_of_your_business')->nullable();
			$table->string('policies')->nullable();
			$table->string('checkbox1')->nullable();
			$table->string('checkbox2')->nullable();
			$table->string('checkbox3')->nullable();
			$table->string('checkbox4')->nullable();
			$table->string('checkbox5')->nullable();
			$table->string('checkbox6')->nullable();
			$table->string('checkbox7')->nullable();
			$table->string('checkbox8')->nullable();
			$table->string('checkbox9')->nullable();
			$table->string('checkbox10')->nullable();
			$table->string('checkbox11')->nullable();
			$table->string('checkbox12')->nullable();
			$table->string('checkbox13')->nullable();
			$table->string('checkbox14')->nullable();
			$table->string('checkbox15')->nullable();
			$table->string('known_supp')->nullable();
			$table->string('checkbox16')->nullable();
			$table->string('external_auditors')->nullable();
			$table->string('instances')->nullable();
			$table->string('checkbox17')->nullable();
			$table->string('technology_platforms')->nullable();

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('mscustomers', function($table)
		{
			$table->dropColumn('nature_of_your_business');
			$table->dropColumn('policies');
			$table->dropColumn('checkbox1');
			$table->dropColumn('checkbox2');
			$table->dropColumn('checkbox3');
			$table->dropColumn('checkbox4');
			$table->dropColumn('checkbox5');
			$table->dropColumn('checkbox6');
			$table->dropColumn('checkbox7');
			$table->dropColumn('checkbox8');
			$table->dropColumn('checkbox9');
			$table->dropColumn('checkbox10');
			$table->dropColumn('checkbox11');
			$table->dropColumn('checkbox12');
			$table->dropColumn('checkbox13');
			$table->dropColumn('checkbox14');
			$table->dropColumn('checkbox15');
			$table->dropColumn('known_supp');
			$table->dropColumn('checkbox16');
			$table->dropColumn('external_auditors');
			$table->dropColumn('instances');
			$table->dropColumn('checkbox17');
			$table->dropColumn('technology_platforms');

		});
	}

}
