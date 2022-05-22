<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescriptionToSlideTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slide_translations', function (Blueprint $table) {
            $table->text('description_2')->nullable()->after('name');
            $table->text('description_1')->nullable()->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('slide_translations', function (Blueprint $table) {
            $table->dropColumn('description_2');
            $table->dropColumn('description_1');
        });
    }
}
