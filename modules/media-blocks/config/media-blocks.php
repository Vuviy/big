<?php

return [
    'widgets' => [
        'media-blocks:media-blocks' => \WezomCms\MediaBlocks\Widgets\MediaBlocks::class,
    ],
    'groups' => [
        'top-categories-1' => [
            'name' => 'cms-media-blocks::admin.Home top categories 1',
        ],
        'top-categories-2' => [
            'name' => 'cms-media-blocks::admin.Home top categories 2',
        ],
        'top-categories-3' => [
            'name' => 'cms-media-blocks::admin.Home top categories 3',
        ],
    ],
    'images' => [
        'directory' => 'media-blocks',
        'default' => 'medium',
        'multilingual' => true,
        'sizes' => [
            'medium' => [
                'width' => 417,
                'height' => 253,
                'mode' => 'fit',
            ],
        ],
    ],
    'video' => [
        'directory' => 'media-blocks-videos',
        'multilingual' => true,
        'max_file_size' => '20', // MB
        'default' => 'main',
        'sizes' => [
            'main' => [
                'width' => 855,
                'height' => 333,
            ],
        ]
    ],
];
