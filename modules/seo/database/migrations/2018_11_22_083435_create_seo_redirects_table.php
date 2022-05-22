<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use WezomCms\Seo\Enums\RedirectHttpStatus;

class CreateSeoRedirectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seo_redirects', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->boolean('published')->default(true);
            $table->string('link_from')->unique();
            $table->string('link_to');
            $table->enum('http_status', RedirectHttpStatus::getValues());
            $table->timestamps();

            $table->unique(['link_from', 'link_to']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seo_redirects');
    }
}
