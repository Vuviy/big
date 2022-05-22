<?php

namespace WezomCms\Catalog\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CategoryRepository
{
    protected static $allForAffiliation;

    public static function allForAffiliation(): Collection
    {
        if (isset(static::$allForAffiliation)) {
            return static::$allForAffiliation;
        }

        return static::$allForAffiliation = DB::table('categories')->select('id', 'parent_id')->get()->keyBy('id');
    }
}
