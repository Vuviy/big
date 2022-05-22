<?php

use WezomCms\Seo\Http\Controllers\Admin\ImportRedirectsController;
use WezomCms\Seo\Http\Controllers\Admin\LinksController;
use WezomCms\Seo\Http\Controllers\Admin\RedirectsController;
use WezomCms\Seo\Http\Controllers\Admin\SeoController;

Route::adminResource('seo-links', LinksController::class);

Route::adminResource('seo-redirects', RedirectsController::class);

Route::prefix('seo-redirects')->group(function () {
    Route::get('import', [ImportRedirectsController::class, 'form'])->name('seo-redirects.form');
    Route::post('import', [ImportRedirectsController::class, 'import'])->name('seo-redirects.import');
});

Route::settings('seo', SeoController::class);
