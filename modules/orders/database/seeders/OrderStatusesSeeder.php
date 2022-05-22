<?php

namespace WezomCms\Orders\Database\Seeders;

use Illuminate\Database\Seeder;
use WezomCms\Orders\Models\OrderStatus;

/**
 * Class OrderStatusesSeeder
 * @package WezomCms\Orders\Database\Seeders
 */
class OrderStatusesSeeder extends Seeder
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
                'id' => OrderStatus::NEW,
                'deletable' => false,
                'ru' => ['name' => 'Новый заказ'],
            ],
            [
                'id' => OrderStatus::DONE,
                'deletable' => false,
                'ru' => ['name' => 'Реализовано'],
            ],
            [
                'id' => OrderStatus::CANCELED,
                'deletable' => false,
                'ru' => ['name' => 'Отменено'],
            ],
        ];

        foreach ($data as $row) {
            if (!OrderStatus::where('id', $row['id'])->count()) {
                OrderStatus::create($row);
            }
        }
    }
}
