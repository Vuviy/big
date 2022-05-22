<?php

use WezomCms\News\Dashboards;
use WezomCms\News\Widgets;

return [
    'use_tags' => false,
    'images' => [
        'directory' => 'news',
        'default' => 'medium',
        'sizes' => [
            'medium' => [
                'width' => 330,
                'height' => 176,
                'mode' => 'resize',
            ],
            'big' => [
                'width' => 1140,
                'height' => 725,
                'mode' => 'fit',
            ],
        ],
    ],
    'widgets' => [
//        'news:most-viewed' => Widgets\MostViewed::class,
        'news:latest' => Widgets\LatestNews::class,
//        'news:tags' => Widgets\Tags::class,
    ],
    'sitemap' => [
        'news' => true, // Enable/disable render links to all published news in sitemap page.
        'tags' => false // Enable/disable render links to all published news tags in sitemap page.
    ],
    'dashboards' => [
        Dashboards\NewsDashboard::class,
    ]
];
