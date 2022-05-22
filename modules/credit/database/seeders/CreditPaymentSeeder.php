<?php

namespace WezomCms\Credit\Database\Seeders;

use Illuminate\Database\Seeder;
use WezomCms\Credit\Drivers\Credit;
use WezomCms\Orders\Models\Payment;

class CreditPaymentSeeder extends Seeder
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
                'driver' => Credit::DRIVER,
                'ru' => ['name' => 'Кредит или рассрочка'],
                'sort' => 2,
            ],
        ];

        foreach ($data as $row) {
            Payment::updateOrCreate(['driver' => $row['driver']], $row);
        }
    }
}
