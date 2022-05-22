<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLocalityIdToOrderDeliveryInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('orders')->delete();

        Schema::table('order_delivery_information', function (Blueprint $table) {
            $table->foreignId('locality_id')->after('order_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->float('delivery_cost')->unsigned()->default(0)->after('delivery_address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_delivery_information', function (Blueprint $table) {
            $table->dropForeign(['locality_id']);
            $table->dropColumn(['locality_id', 'delivery_cost']);
        });
    }
}
