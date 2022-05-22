<?php

use WezomCms\Ui\Widgets;

return [
    'manifest_path' => [
        'svg' => 'svg/manifest.json',
        'src' => 'build/manifest.{mode}.json',
    ],
    'svg' => [
        'features' => 'svg/features.svg',
        'common' => 'svg/common.svg',
    ],
    'widgets' => [
        // Site
        'ui:breadcrumbs' => Widgets\Breadcrumbs::class,
        'ui:footer' => Widgets\Footer::class,
        'ui:header' => Widgets\Header::class,
        'ui:hidden-data' => Widgets\HiddenData::class,
        'ui:lang-switcher' => Widgets\LangSwitcher::class,
        'ui:share' => Widgets\Share::class,
        'ui:unsupported-browser' => Widgets\UnsupportedBrowser::class,
        'ui:button' => Widgets\Button::class,
    ],
    'pagination' => [
        'default' => 'cms-ui::pagination.wezom',
        'simple' => 'cms-ui::pagination.simple-wezom',
    ],
];
