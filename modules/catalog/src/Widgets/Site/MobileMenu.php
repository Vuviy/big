<?php

namespace WezomCms\Catalog\Widgets\Site;

use WezomCms\Catalog\Models\Category;
use WezomCms\Catalog\Models\CategoryTranslation;
use WezomCms\Catalog\Services\CatalogMenuBuilderService;
use WezomCms\Core\Foundation\Widgets\AbstractWidget;
use WezomCms\Core\Models\Translation;
use WezomCms\Menu\Models\Menu;
use WezomCms\Menu\Models\MenuTranslation;
use WezomCms\Menu\Services\MenuBuilderService;

class MobileMenu extends AbstractWidget
{
    protected $view = 'cms-catalog::site.widgets.mobile-menu';

    /**
     * A list of models that, when changed, will clear the cache of this widget.
     *
     * @var array
     */
    public static $models = [Category::class, CategoryTranslation::class, Menu::class, MenuTranslation::class, Translation::class];

    /**
     * @return array|null
     */
    public function execute(): ?array
    {
        $categories = CatalogMenuBuilderService::getCategoriesForCatalogMenu();

        if ($categories->isEmpty()) {
            return null;
        }

        $menuLast = array_get(MenuBuilderService::getMenuTree(), Menu::HEADER_CATALOG_GROUP, collect())->last();

        return compact('categories', 'menuLast');
    }
}
