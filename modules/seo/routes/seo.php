<?php

use WezomCms\Seo\Http\Controllers\Site\RobotsController;

Route::get('robots.txt', RobotsController::class)->middleware('web')->name('robots');
