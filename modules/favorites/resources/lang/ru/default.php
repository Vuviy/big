<?php

use WezomCms\Core\Enums\TranslationSide;

return [
    TranslationSide::ADMIN => [
        'Favorites' => 'Избранное',
        'Title' => 'Title',
        'Site favorites products limit at page' => 'Количество товаров на странице списка избранных товаров',
        'Edit favorites settings' => 'Редактировать настройки избранных товаров',
        'Wish list' => 'Список желаний',
    ],
    TranslationSide::SITE => [
        'Payload' => 'Данные',
        'Favorite products' => 'Избранные товары',
        'Wish list' => 'Список желаний',
        'Favorable not found' => 'Объект для добавления в избранное не найден',
        'Items total cost' => 'товаров на сумму',
        'sort_variant' => [
            'top' => 'По популярности',
            'cheap' => 'Сначала дешевле',
            'expensive' => 'Сначала дорогие',
            'novelty' => 'По новизне',
        ],
        'Product added to favorites' => 'Товар добавлен в избранное!',
    ],
];
