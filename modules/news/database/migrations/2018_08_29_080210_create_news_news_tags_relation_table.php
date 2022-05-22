<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsNewsTagsRelationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_news_tags_relation', function (Blueprint $table) {
            $table->foreignId('news_id')->constrained()->cascadeOnDelete();
            $table->foreignId('news_tag_id')->constrained()->cascadeOnDelete();
            $table->primary(['news_id', 'news_tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news_news_tags_relation');
    }
}
