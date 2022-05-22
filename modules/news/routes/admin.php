<?php

use WezomCms\News\Http\Controllers\Admin\NewsController;
use WezomCms\News\Http\Controllers\Admin\NewsTagsController;

Route::adminResource('news', NewsController::class)->settings();

if (config('cms.news.news.use_tags')) {
    Route::adminResource('news-tags', NewsTagsController::class);
}
