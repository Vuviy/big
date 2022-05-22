<?php

return [
    'max_depth' => 3,
    'images' => [
        'image' => [
            'directory' => 'categories/images',
            'default' => 'small',
            'sizes' => [
                'small' => [
                    'width' => 80,
                    'height' => 72,
                    'mode' => 'resize',
                ],
            ],
        ],
        'top-categories-1' => [
            'directory' => 'categories/images',
            'default' => 'medium',
            'sizes' => [
                'medium' => [
                    'width' => 300,
                    'height' => 200,
                    'mode' => 'resize',
                ],
            ],
        ],
        'top-categories-2' => [
            'directory' => 'categories/images',
            'default' => 'medium',
            'sizes' => [
                'medium' => [
                    'width' => 415,
                    'height' => 253,
                    'mode' => 'resize',
                ],
                'big' => [
                    'width' => 850,
                    'height' => 333,
                    'mode' => 'resize',
                ]
            ],
        ],
        'top-categories-3' => [
            'directory' => 'categories/images',
            'default' => 'medium',
            'sizes' => [
                'medium' => [
                    'width' => 336,
                    'height' => 188,
                    'mode' => 'resize',
                ]
            ],
        ],
    ],
];
