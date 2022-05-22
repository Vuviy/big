<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaqQuestionTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faq_question_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('faq_question_id')->constrained()->cascadeOnDelete();
            $table->string('locale')->index();
            $table->string('question');
            $table->mediumText('answer')->nullable();

            $table->unique(['faq_question_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faq_question_translations');
    }
}
