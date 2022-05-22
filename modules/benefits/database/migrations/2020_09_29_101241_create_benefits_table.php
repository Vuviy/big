<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBenefitsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('benefits', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->integer('sort')->default(0);
			$table->boolean('published')->default(true);
            $table->string('image')->nullable();
            $table->string('icon')->nullable();
            $table->boolean('for_main')->default(true);
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
		Schema::dropIfExists('benefits');
	}
}
