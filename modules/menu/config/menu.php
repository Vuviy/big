<?php

use WezomCms\Menu\Widgets;
use WezomCms\Menu\Models\Menu;

return [
    'widgets' => [
        'menu:header' => Widgets\Site\HeaderMenu::class,
        'menu:footer' => Widgets\Site\FooterMenu::class,
        'menu:mobile' => Widgets\Site\MobileMenu::class,
    ],
    'groups' => [
        Menu::HEADER_GROUP => [
            'name' => 'cms-menu::admin.Header',
            'depth' => 1,
        ],
        Menu::HEADER_CATALOG_GROUP => [
            'name' => 'cms-menu::admin.Header catalog categories',
            'depth' => 1,
        ],
        Menu::FOOTER_GROUP => [
            'name' => 'cms-menu::admin.Footer',
            'depth' => 2,
        ],
        Menu::MOBILE_GROUP => [
            'name' => 'cms-menu::admin.Mobile',
            'depth' => 1,
        ],
    ],
];
