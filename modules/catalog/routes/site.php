<?php

use WezomCms\Catalog\Http\Controllers\Site\CatalogController;
use WezomCms\Catalog\Http\Controllers\Site\CategoryController;
use WezomCms\Catalog\Http\Controllers\Site\ProductController;
use WezomCms\Catalog\Http\Controllers\Site\SearchController;

Route::prefix('catalog')->name('catalog')->group(function () {
    Route::filter('', '', CatalogController::class);

    Route::filter(
        '.category',
        '{slug}/c{id}',
        CategoryController::class,
        ['slug' => '[\pL\pM\pN_-]+', 'id' => '\d+']
    );

    Route::get('{slug}/p{id}', ProductController::class)
        ->name('.product')
        ->where(['slug' => '[\pL\pM\pN_-]+', 'id' => '\d+']);
    Route::get('product-reviews/{product_id}', [ProductController::class, 'moreReviews'])->name('.product.reviews-more')
        ->where(['product_id' => '\d+']);
});

Route::prefix('search')->name('search')->group(function () {
    Route::filter('', '', [SearchController::class, 'index']);

    Route::get('/live', [SearchController::class, 'liveSearch'])->name('.live');
});
