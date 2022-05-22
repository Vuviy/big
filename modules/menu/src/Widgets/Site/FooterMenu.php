<?php

namespace WezomCms\Menu\Widgets\Site;

use WezomCms\Core\Foundation\Widgets\AbstractWidget;
use WezomCms\Core\Models\Translation;
use WezomCms\Menu\Models\Menu;
use WezomCms\Menu\Models\MenuTranslation;
use WezomCms\Menu\Services\MenuBuilderService;

class FooterMenu extends AbstractWidget
{
    protected $view = 'cms-menu::site.widgets.footer';

    public static $models = [Menu::class, MenuTranslation::class, Translation::class];

    public function execute()
    {
        return [
            'menu' => array_get(MenuBuilderService::getMenuTree(), Menu::FOOTER_GROUP, collect()),
        ];
    }
}
