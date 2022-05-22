<?php

namespace WezomCms\Catalog\Services;

use WezomCms\Catalog\Models\Category;

class CatalogMenuBuilderService
{
    protected static $categoriesForCatalogMenu;

    public static function getCategoriesForCatalogMenu()
    {
        if (isset(static::$categoriesForCatalogMenu)) {
            return static::$categoriesForCatalogMenu;
        }

        return static::$categoriesForCatalogMenu = Category::published()
            ->whereNull('parent_id')
            ->where('show_on_menu', true)
            ->sorting()
            ->with([
                'children' => function ($query) {
                    $query->where('show_on_menu', true)
                        ->published()
                        ->sorting()
                        ->with([
                            'children' => function ($query) {
                                $query->where('show_on_menu', true)
                                    ->published()
                                    ->sorting();
                            }
                        ]);
                }
            ])
            ->limit(settings('categories.site.categories_menu_limit', 12))
            ->get();
    }
}
