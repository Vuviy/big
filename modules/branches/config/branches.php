<?php

use WezomCms\Branches\Dashboards;
use WezomCms\Branches\Widgets;

return [
    'widgets' => [
//        'branches:list' => Widgets\Branches::class,
//        'branches:phones' => Widgets\Phones::class,
    ],
    'dashboards' => [
        Dashboards\BranchesDashboard::class,
    ],
];
