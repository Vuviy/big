<?php

use WezomCms\Credit\Http\Controllers\Admin\ChangeLoanApplicationStatusController;
use WezomCms\Credit\Http\Controllers\Admin\CreditController;
use WezomCms\Credit\Http\Controllers\Admin\HomeCreditCoefficientController;

Route::settings('credit', CreditController::class);

Route::adminResource('home-credit-coefficients', HomeCreditCoefficientController::class)->settings();

Route::post('change-loan-application-status/{order_payment_information}/{status}', ChangeLoanApplicationStatusController::class)
    ->where(['order_payment_id' => '\d+', 'status' => '[\pL\pM\pN_-]+'])
    ->name('change-loan-application-status');
