<?php

use WezomCms\Callbacks\Dashboards;
use WezomCms\Callbacks\Widgets\CallbackButton;

return [
    'widgets' => [
        'callbacks:button' => CallbackButton::class,
    ],
    'dashboards' => [
        Dashboards\CallbacksDashboard::class,
        //Dashboards\CallbacksNoActiveDashboard::class,
    ],
];
