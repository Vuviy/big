<?php

use WezomCms\Orders\Http\Controllers\Admin\DeliveriesController;
use WezomCms\Orders\Http\Controllers\Admin\OrdersController;
use WezomCms\Orders\Http\Controllers\Admin\OrderStatusesController;
use WezomCms\Orders\Http\Controllers\Admin\PaymentsController;

// Orders
Route::adminResource('orders', OrdersController::class)->softDeletes()->show()->settings();

Route::prefix('orders')->name('orders.')->group(function () {
    Route::get('/{id}/add-item', [OrdersController::class, 'addItem'])->name('add-item');
    Route::post('/{id}/store-item', [OrdersController::class, 'storeItem'])->name('store-item');
    Route::get('/{id}/delete-item/{item_id}', [OrdersController::class, 'deleteItem'])->name('delete-item');
    Route::post('/render-delivery-form', [OrdersController::class, 'renderDeliveryForm'])
        ->name('render-delivery-form');
    Route::post('/render-payment-form', [OrdersController::class, 'renderPaymentForm'])
        ->name('render-payment-form');
});

// Statuses
Route::adminResource('order-statuses', OrderStatusesController::class);

//Deliveries
Route::adminResource('deliveries', DeliveriesController::class)->settings();

//Payments
Route::adminResource('payments', PaymentsController::class)->settings();
