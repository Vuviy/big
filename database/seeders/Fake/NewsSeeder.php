<?php

namespace Database\Seeders\Fake;

use Illuminate\Database\Seeder;
use WezomCms\News\Models\News;

class NewsSeeder extends Seeder
{
    public function run()
    {
        if (!News::count()) {
            News::factory()
                ->count(120)
                ->create();
        }
    }
}
