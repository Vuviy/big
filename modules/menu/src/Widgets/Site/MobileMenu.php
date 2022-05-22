<?php

namespace WezomCms\Menu\Widgets\Site;

use WezomCms\Core\Foundation\Widgets\AbstractWidget;
use WezomCms\Core\Models\Translation;
use WezomCms\Menu\Models\Menu;
use WezomCms\Menu\Models\MenuTranslation;
use WezomCms\Menu\Services\MenuBuilderService;

class MobileMenu extends AbstractWidget
{
    protected $view = 'cms-menu::site.widgets.mobile-menu';

    public static $models = [Menu::class, MenuTranslation::class, Translation::class];

    public function execute()
    {
        return [
            'menu' => array_get(MenuBuilderService::getMenuTree(), Menu::MOBILE_GROUP, collect()),
        ];
    }
}
