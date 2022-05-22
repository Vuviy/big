<?php

namespace WezomCms\Orders\Database\Seeders;

use Illuminate\Database\Seeder;
use WezomCms\Orders\Drivers\Delivery\Courier;
use WezomCms\Orders\Models\Delivery;

class DeliveriesSeeder extends Seeder
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
                'driver' => Courier::KEY,
                'ru' => ['name' => 'Курьер по адресу'],
            ],
        ];

        foreach ($data as $row) {
            if (!Delivery::where('driver', $row['driver'])->count()) {
                Delivery::create($row);
            }
        }
    }
}
