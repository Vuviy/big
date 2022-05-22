<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsUsersTable extends Migration
{

    public function up() :void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->json('communication')->nullable();
            $table->timestamp('birthday')->nullable();
        });
    }

    public function down() : void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('communication');
            $table->dropColumn('birthday');
        });
    }
}
