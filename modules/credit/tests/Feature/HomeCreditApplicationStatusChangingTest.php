<?php

namespace WezomCms\Credit\Tests\Feature;

use Tests\TestCase;
use WezomCms\Credit\Banks\HomeCreditBank;
use WezomCms\Credit\Drivers\Credit;
use WezomCms\Orders\Models\Order;
use WezomCms\Orders\Models\Payment;

class HomeCreditApplicationStatusChangingTest extends TestCase
{
    public function testChangeCreditApplicationStatus()
    {
        $order = Order::create();
        $order->payment()->associate(Payment::firstWhere('driver', Credit::DRIVER));
        $order->save();
        $order->paymentInformation()->create(['bank' => HomeCreditBank::getType()]);

        $requestParams = [
            'status' => 'APPROVED',
            'orderNo' => $order->id,
            'authkey' => settings('home-credit.site.auth_key'),
            'productCode' => 'productCode',
            'contractCode' => 'contractCode',
        ];

        $response = $this->post('home-credit/status', $requestParams);

        $response->assertOk();

        $this->assertDatabaseHas('order_payment_information', [
            'order_id' => $order->id,
            'bank_order_no' => array_get($requestParams, 'orderNo'),
            'bank_contract_code' => array_get($requestParams, 'contractCode'),
            'repayment_period' => array_get($requestParams, 'productTerm'),
            'bank_product_code' => array_get($requestParams, 'productCode'),
            'bank_status' => array_get($requestParams, 'status')
        ]);
    }
}
