<?php

namespace WezomCms\Catalog\Widgets\Site;

use WezomCms\Catalog\Models\Category;
use WezomCms\Catalog\Models\CategoryTranslation;
use WezomCms\Catalog\Services\CatalogMenuBuilderService;
use WezomCms\Core\Foundation\Widgets\AbstractWidget;
use WezomCms\Core\Models\Translation;

class MenuTree extends AbstractWidget
{
    /**
     * A list of models that, when changed, will clear the cache of this widget.
     *
     * @var array
     */
    public static $models = [Category::class, CategoryTranslation::class, Translation::class];

    /**
     * @return array|null
     */
    public function execute(): ?array
    {
        $categories = CatalogMenuBuilderService::getCategoriesForCatalogMenu();

        if ($categories->isEmpty()) {
            return null;
        }

        return compact('categories');
    }
}
