<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBenefitsTranslatesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('benefits_translations', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedBigInteger('benefits_id');
			$table->string('locale')->index();
			$table->string('name')->nullable();

			$table->unique(['benefits_id', 'locale']);
			$table->foreign('benefits_id')
				->references('id')
				->on('benefits')
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
		Schema::dropIfExists('benefits_translations');
	}
}

