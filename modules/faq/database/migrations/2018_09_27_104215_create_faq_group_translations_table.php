<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaqGroupTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faq_group_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('faq_group_id')->constrained()->cascadeOnDelete();
            $table->string('locale')->index();
            $table->string('name');

            $table->unique(['faq_group_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faq_group_translations');
    }
}
