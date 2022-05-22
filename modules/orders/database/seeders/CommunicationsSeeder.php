<?php

namespace WezomCms\Orders\Database\Seeders;

use Illuminate\Database\Seeder;
use WezomCms\Orders\Models\Communication;

class CommunicationsSeeder extends Seeder
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
                'driver' => Communication::PHONE,
                'ru' => ['name' => 'Телефон'],
            ],
            [
                'driver' => Communication::VIBER,
                'ru' => ['name' => 'Viber'],
            ],
            [
                'driver' => Communication::TELEGRAM,
                'ru' => ['name' => 'Telegram'],
            ],
        ];

        foreach ($data as $row) {
            if (!Communication::where('driver', $row['driver'])->count()) {
                Communication::create($row);
            }
        }
    }
}
