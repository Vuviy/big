<?php

use WezomCms\About\Http\Controllers\Admin\AboutController;
use WezomCms\About\Http\Controllers\Admin\AboutEventsController;
use WezomCms\About\Http\Controllers\Admin\AboutReviewsController;

Route::settings('about', AboutController::class);
Route::adminResource('about-events', AboutEventsController::class)->settings();
Route::adminResource('about-reviews', AboutReviewsController::class)->settings();
