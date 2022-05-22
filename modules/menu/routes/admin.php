<?php

use WezomCms\Menu\Http\Controllers\MenuController;

Route::adminResource('menu', MenuController::class);

Route::prefix('menu')->name('menu.')->group(function () {
    Route::get('/{group}/get-parents-list', [MenuController::class, 'getParentsList'])->name('get-parents-list');
    Route::get('/copy/{id}/{group}', [MenuController::class, 'copy'])->name('copy');
});
