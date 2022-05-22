<?php

namespace Database\Seeders\Fake;

use Illuminate\Database\Seeder;
use WezomCms\Faq\Models\FaqQuestion;

class FaqSeeder extends Seeder
{
    public function run()
    {
        if (!FaqQuestion::count()) {
            FaqQuestion::factory()
                ->count(150)
                ->create();
        }
    }
}
