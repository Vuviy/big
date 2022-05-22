<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaBlockTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_block_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('media_block_id')->unsigned();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('url')->nullable();
            $table->string('locale')->index();
            $table->string('image')->nullable();
            $table->string('video')->nullable();

            $table->unique(['media_block_id', 'locale']);
            $table->foreign('media_block_id')->references('id')->on('media_blocks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media_block_translations');
    }
}
