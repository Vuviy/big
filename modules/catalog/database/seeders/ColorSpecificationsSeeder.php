<?php

namespace WezomCms\Catalog\Database\Seeders;

use Illuminate\Database\Seeder;
use WezomCms\Catalog\Models\Specifications\Specification;

class ColorSpecificationsSeeder extends Seeder
{
    public function run()
    {
        $color = new Specification();
        $color->type = Specification::COLOR;
        $color->name = 'Цвет';
        $color->published = true;
        $color->save();
    }
}
