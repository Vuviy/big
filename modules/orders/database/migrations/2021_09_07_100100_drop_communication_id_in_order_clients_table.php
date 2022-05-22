<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropCommunicationIdInOrderClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_clients', function (Blueprint $table) {
            $table->dropForeign(['communication_id']);
            $table->dropColumn('communication_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_clients', function (Blueprint $table) {
            $table->foreignId('communication_id')->nullable()->constrained()->nullOnDelete();
        });
    }
}
