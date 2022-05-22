<?php

use WezomCms\Users\Http\Controllers\Admin\UsersController;
use WezomCms\Users\Http\Controllers\Admin\UserAddressController;

Route::adminResource('users', UsersController::class)->settings();

Route::prefix('users')->name('users.')->group(function () {
    Route::get('/{id}/auth', [UsersController::class, 'auth'])->name('auth');

    Route::get('/search', [UsersController::class, 'search'])->name('search');
});

Route::adminResource('user-addresses', UserAddressController::class);
