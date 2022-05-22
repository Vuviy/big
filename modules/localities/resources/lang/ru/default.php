<?php

use WezomCms\Core\Enums\TranslationSide;

return [
    TranslationSide::ADMIN => [
        'Localities' => 'Населенные пункты',
        'Name' => 'Название',
        'Delivery cost' => 'Стоимость доставки',
        'City' => 'Город',
        'Cities' => 'Города',
        'Locations' => 'Локации',
        'Index' => 'Индекс',
        'You cannot delete this item because there are settlements dependent on it' => 'Вы не можете удалить этот элемент, потому что существуют зависимые от него населенные пункты',
        'You cannot delete this item because there is an order with this shipping locality' => 'Вы не можете удалить этот элемент, потому что существует заказ с доставкой в этот населенный пункт',
    ],
    TranslationSide::SITE => [
    ],
];
