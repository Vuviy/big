<?php

use WezomCms\Faq\Http\Controllers\Admin\FaqGroupsController;
use WezomCms\Faq\Http\Controllers\Admin\FaqController;

Route::adminResource('faq', FaqController::class)->settings();

if (config('cms.faq.faq.use_groups')) {
    Route::adminResource('faq-groups', FaqGroupsController::class);
}
