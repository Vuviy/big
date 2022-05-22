<?php

namespace WezomCms\Favorites\Facades;

use Illuminate\Support\Facades\Facade;

class Favorites extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    public static function getFacadeAccessor()
    {
        return 'favorites';
    }
}
