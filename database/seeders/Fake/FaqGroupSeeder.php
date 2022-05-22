<?php

namespace Database\Seeders\Fake;

use Illuminate\Database\Seeder;
use WezomCms\Faq\Models\FaqGroup;

class FaqGroupSeeder extends Seeder
{
    public function run()
    {
        if (!FaqGroup::count()) {
            FaqGroup::factory()
                ->count(4)
                ->create();
        }
    }
}
