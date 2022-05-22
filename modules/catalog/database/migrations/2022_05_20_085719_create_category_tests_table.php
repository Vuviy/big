<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_tests', function (Blueprint $table) {
            $table->id();
            $table->boolean('published')->default(true);
            $table->boolean('show_on_main')->default(false);
            $table->boolean('show_on_menu')->default(false);
            $table->integer('sort')->default(0)->index();
            $table->foreignId('parent_id')->nullable()->constrained('category_tests')->nullOnDelete();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('category_tests');
    }
}
