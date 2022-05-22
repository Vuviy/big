<?php

namespace WezomCms\Orders\Database\Seeders;

use Illuminate\Database\Seeder;
use WezomCms\Orders\Drivers\Payment\Cash;
use WezomCms\Orders\Enums\PaymentTypes;
use WezomCms\Orders\Models\Payment;

class PaymentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'driver' => Cash::KEY,
                'ru' => ['name' => 'Наличными'],
                'sort' => 0,
            ],
            [
                'driver' => PaymentTypes::CLOUD_PAYMENT,
                'ru' => ['name' => 'Оплата на карту'],
                'sort' => 1,
            ],
        ];

        foreach ($data as $row) {
            Payment::updateOrCreate(['driver' => $row['driver']], $row);
        }
    }
}
