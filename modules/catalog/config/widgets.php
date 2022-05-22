<?php

use WezomCms\Catalog\Dashboards;
use WezomCms\Catalog\Widgets;

return [
    'widgets' => [
        // Admin
        'catalog:brand-with-model' => Widgets\Admin\BrandWithModel::class,
        'catalog:product-specifications-tab' => Widgets\Admin\ProductSpecificationsTab::class,
        // Site
//        'catalog:viewed' => Widgets\Site\Viewed::class,
        'catalog:same-products' => Widgets\Site\SameProducts::class,
        'catalog:mobile-menu' => Widgets\Site\MobileMenu::class,
        'catalog:header-menu' => Widgets\Site\HeaderMenu::class,
        'catalog:menu-tree' => Widgets\Site\MenuTree::class,
        'catalog:novelty' => Widgets\Site\Novelty::class,
        'catalog:popular' => Widgets\Site\Popular::class,
        'catalog:sale' => Widgets\Site\Sale::class,
//        'catalog:buy-with-this-product' => Widgets\Site\BuyWithThisProduct::class,
        'catalog:catalog-flag-filter' => Widgets\Site\CatalogFlagFilter::class,
        'catalog:product-labels' => Widgets\Site\ProductLabels::class,
    ],
    'dashboards' => [
        Dashboards\CategoriesDashboard::class,
        Dashboards\ProductsDashboard::class,
        //Dashboards\AvailableProductsDashboard::class,
    ],
];
