<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use WezomCms\Credit\Enums\CreditType;

class CreateHomeCreditCoefficientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home_credit_coefficients', function (Blueprint $table) {
            $table->id();
            $table->boolean('published')->default(true)->index();
            $table->unsignedTinyInteger('month')->index();
            $table->enum('type', CreditType::getValues());
            $table->string('coefficient');
            $table->unsignedInteger('availability');
            $table->unsignedBigInteger('max_sum');
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
        Schema::dropIfExists('home_credit_coefficients');
    }
}
