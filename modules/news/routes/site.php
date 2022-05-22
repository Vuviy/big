<?php

use WezomCms\News\Http\Controllers\Site\NewsController;

Route::prefix('news')->name('news')->group(function () {
    Route::get('', [NewsController::class, 'index']);

    Route::get('/{slug}', [NewsController::class, 'inner'])->name('.inner');
});

if (config('cms.news.news.use_tags')) {
    Route::get('tag/{tag}', [NewsController::class, 'tag'])->where('tag', '[\pL\pM\pN_-]+')->name('news.tag');
}
