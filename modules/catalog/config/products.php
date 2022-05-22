<?php

return [
    'images' => [
        'directory' => 'products/images',
        'default' => 'medium',
        'sizes' => [
            'small' => [
                'width' => 124,
                'height' => 96,
                'mode' => 'resize',
            ],
            'medium' => [
                'width' => 192,
                'height' => 192,
                'mode' => 'resize',
            ],
            'big' => [
                'width' => 480,
                'height' => 590,
                'mode' => 'resize',
            ],
        ],
    ],
    'filter' => [
        'parameters' => [
            // 'brand' => [
            //     'mode' => 'multiple',
            // ],
            // 'model' => [
            //     'mode' => 'multiple',
            // ],
            'cost-from' => [
                'mode' => 'number_range',
            ],
            'cost-to' => [
                'mode' => 'number_range',
            ],
            'specifications' => [
                'mode' => 'multiple',
            ],
        ],
    ],
    'sort' => [
        'url_key' => 'sort',
        'variants' => [
            'created-at' => [
                'name' => 'cms-catalog::site.products.sort.Created at',
                'field' => 'id',
                'direction' => 'DESC',
            ],
            'default' => [
                'name' => 'cms-catalog::site.products.sort.Default',
                'field' => [
                    'sort' => 'ASC',
                    'id' => 'DESC',
                ],
            ],
            'cost-asc' => [
                'name' => 'cms-catalog::site.products.sort.Cost asc',
                'field' => 'cost',
                'direction' => 'ASC',
            ],
            'cost-desc' => [
                'name' => 'cms-catalog::site.products.sort.Cost desc',
                'field' => 'cost',
                'direction' => 'DESC',
            ],
        ],
    ],
];
