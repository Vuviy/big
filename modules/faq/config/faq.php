<?php

use WezomCms\Faq\Dashboards;

return [
    'use_groups' => true,
    'dashboards' => [
        Dashboards\FaqDashboard::class,
        //Dashboards\FaqPublishedDashboard::class,
    ],
];
