<?php

use WezomCms\Users\Dashboard;
use WezomCms\Users\Widgets;

return [
    'sms_service' => 'esputnik', // Support: turbosms, esputnik
    'password_min_length' => 8,
    'password_max_length' => 30,
    'supported_socials' => [
        'facebook',
        'google',
//        'twitter',
    ],
    'socials' => [
        'facebook' => [
            'scopes' => ['email'],
            'fields' => ['first_name', 'last_name', 'email'],
            'fields_mapping' => [
                'name' => 'first_name',
                'surname' => 'last_name',
            ],
        ],
        'google' => [
            'fields_mapping' => [
                'name' => 'given_name',
                'surname' => 'family_name',
            ],
        ],
    ],
    'widgets' => [
        'cabinet-button' => Widgets\CabinetButton::class,
        'cabinet-menu' => Widgets\CabinetMenu::class,
//        'cabinet-submenu' => Widgets\CabinetSubMenu::class,
//        'cabinet-socials' => Widgets\CabinetSocials::class,
        'cabinet-auth-socials' => Widgets\CabinetAuthSocials::class,
    ],
    'dashboards' => [
        Dashboard\UsersDashboard::class,
    ],

    'communications' => [
        'phone'    => 'cms-user::site.communication.Телефон',
        'viber'    => 'cms-user::site.communication.Viber',
        'telegram' => 'cms-user::site.communication.Telegram'
    ]
];
