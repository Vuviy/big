<?php

namespace WezomCms\Catalog\Widgets\Site;

use WezomCms\Core\Foundation\Widgets\AbstractWidget;
use WezomCms\Core\Models\Translation;
use WezomCms\Menu\Models\Menu;
use WezomCms\Menu\Models\MenuTranslation;
use WezomCms\Menu\Services\MenuBuilderService;

class HeaderMenu extends AbstractWidget
{
    /**
     * A list of models that, when changed, will clear the cache of this widget.
     *
     * @var array
     */
    public static $models = [Menu::class, MenuTranslation::class, Translation::class];

    /**
     * @return array|null
     */
    public function execute(): ?array
    {
        $menu = array_get(MenuBuilderService::getMenuTree(), Menu::HEADER_CATALOG_GROUP, collect());

        return compact('menu');
    }
}
