<?php

use WezomCms\Sitemap\Http\Controllers\Site\SitemapController;

Route::get('sitemap', SitemapController::class)->name('sitemap');
