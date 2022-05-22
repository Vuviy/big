<?php

use WezomCms\Newsletter\Http\Controllers\Admin\NewsletterController;
use WezomCms\Newsletter\Http\Controllers\Admin\SubscribersController;

Route::adminResource('subscribers', SubscribersController::class);

Route::prefix('newsletter')->name('newsletter.')->group(function () {
    Route::get('/form', [NewsletterController::class, 'form'])->name('form');
    Route::post('/send', [NewsletterController::class, 'send'])->name('send');
    Route::get('/list', [NewsletterController::class, 'list'])->name('index');
    Route::get('/list/{id}/show', [NewsletterController::class, 'show'])->name('show');
});
