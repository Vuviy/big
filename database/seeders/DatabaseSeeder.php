<?php

namespace Database\Seeders;

use Database\Seeders\Fake\CatalogSeeder;
use Database\Seeders\Fake\FaqGroupSeeder;
use Database\Seeders\Fake\FaqSeeder;
use Database\Seeders\Fake\NewsSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(MenuSeeder::class);
        $this->call(NewsSeeder::class);
        $this->call(FaqGroupSeeder::class);
        $this->call(FaqSeeder::class);
        $this->call(CatalogSeeder::class);
    }
}
