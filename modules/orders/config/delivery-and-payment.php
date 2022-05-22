<?php

return [
    'delivery_variant' => [
        'images' => [
            'directory' => 'delivery-variants',
            'default' => 'small',
            'sizes' => [
                'small' => [
                    'width' => 300,
                    'height' => 75,
                    'mode' => 'resize',
                ],
            ],
        ],
    ],
    'payment_variant' => [
        'images' => [
            'directory' => 'payment-variants',
            'default' => 'small',
            'sizes' => [
                'small' => [
                    'width' => 300,
                    'height' => 75,
                    'mode' => 'resize',
                ],
            ],
        ],
    ],
];
