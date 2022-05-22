<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderPaymentInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_payment_information', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('ipn')->nullable()->comment('иин');
            $table->unsignedSmallInteger('repayment_period')->nullable()->comment('срок погашения кредита');
            $table->string('bank', 50)->nullable();
            $table->string('bank_status')->nullable()->comment('статус заявки в банке');
            $table->string('bank_order_no')->nullable()->comment('номер заявки в банке');
            $table->string('bank_contract_code')->nullable()->comment('номер договора в банке');
            $table->string('bank_product_code')->nullable()->comment('код продукта в банке');
            $table->string('redirect_url')->nullable();
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
        Schema::dropIfExists('order_payment_information');
    }
}
