<?php

namespace WezomCms\Menu\Services;

use WezomCms\Menu\Models\Menu;

class MenuBuilderService
{
    protected static $menuTree;

    public static function getMenuTree()
    {
        if (isset(static::$menuTree)) {
            return static::$menuTree;
        }

        return static::$menuTree = Menu::whereNull('parent_id')
            ->published()
            ->sorting()
            ->with([
                'children' => function ($query) {
                    $query->published()
                        ->sorting();
//                        ->with([
//                            'children' => function ($query) {
//                                $query->published()
//                                    ->sorting()
//                                    ->with([
//                                        'children' => function ($query) {
//                                            $query->published()
//                                                ->sorting();
//                                        }
//                                    ]);
//                            }
//                        ]);
                }
            ])
            ->get()
            ->groupBy('group');
    }
}
