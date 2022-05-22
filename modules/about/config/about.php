<?php

use WezomCms\About\Widgets;

return [
    'widgets' => [
        'about:our-products' => Widgets\Site\OurProducts::class,
        'about:event-history' => Widgets\Site\EventHistory::class,
        'about:our-team' => Widgets\Site\OurTeam::class,
        'about:reviews' => Widgets\Site\Reviews::class,
    ],
    'images' => [
        'about' => [
            'directory' => 'about',
            'default' => 'big',
            'sizes' => [
                'big' => [
                    'width' => 790,
                    'height' => 980,
                    'mode' => 'fit',
                ],
            ],
        ],
    ],
];
