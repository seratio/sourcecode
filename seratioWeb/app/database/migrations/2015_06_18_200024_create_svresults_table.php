<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSvresultsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('svresults', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('socialvalue_id')->unsigned();
			$table->double('social_impact');
			$table->double('social_impact_asap_cap');
			$table->double('added_value');
			$table->double('environment');
			$table->double('people');
			$table->double('cash');
			$table->softDeletes();
			$table->timestamps();

			$table->foreign('socialvalue_id')
				->references('id')
				->on('socialvalues')
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
		Schema::drop('svresults');
	}

}
