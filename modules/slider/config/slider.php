<?php

use WezomCms\Slider\Widgets\Slider;

return [
    'images' => [
        'directory' => 'slides',
        'default' => 'medium',
        'multilingual' => true,
        'sizes' => [
            'medium' => [
                'width' => 1920,
                'height' => 522,
                'mode' => 'resize',
            ],
        ],
    ],
    'image_mobile' => [
        'directory' => 'image_mobile',
        'default' => 'medium',
        'multilingual' => true,
        'sizes' => [
            'medium' => [
                'width' => 550,
                'height' => 360,
                'mode' => 'fit',
            ],
        ],
    ],
    'sliders' => [
        'main' => [
            'name' => 'cms-slider::admin.Main slider',
            'size' => null,
        ],
    ],
    'widgets' => [
        'slider' => Slider::class,
    ],
];
