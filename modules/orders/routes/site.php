<?php

use WezomCms\Orders\Http\Controllers\Site\CabinetOrdersController;
use WezomCms\Orders\Http\Controllers\Site\CheckoutController;
use WezomCms\Orders\Http\Controllers\Site\CloudPaymentController;
use WezomCms\Orders\Http\Controllers\Site\OrderPaymentController;
use WezomCms\Orders\Http\Controllers\Site\ThanksController;
use WezomCms\Orders\Http\Middleware\RedirectToHomeIfCartIsEmpty;

Route::get('thanks/{order}', ThanksController::class)
    ->name('thanks-page')
    ->where('order', '\d+');

Route::match(['get', 'post'], 'payment-callback/{id}/{driver}', OrderPaymentController::class)
    ->name('payment-callback')
    ->where('id', '\d+');

// Checkout
Route::get('checkout', CheckoutController::class)
    ->middleware(RedirectToHomeIfCartIsEmpty::class)
    ->name('checkout');

Route::get('orders', [CabinetOrdersController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('cabinet.orders');

Route::get('reviews-popup/{id}', [CabinetOrdersController::class, 'reviewsPopup'])
    ->middleware('auth', 'verified')
    ->name('orders.reviews-popup')
    ->where('id', '\d+');

Route::get('cloud-payment/{id}', CloudPaymentController::class)
    ->name('cloud-payment');
