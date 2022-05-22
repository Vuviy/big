<?php

use WezomCms\Users\Http\Controllers\Site\Auth\ForgotPasswordController;
use WezomCms\Users\Http\Controllers\Site\Auth\LoginController;
use WezomCms\Users\Http\Controllers\Site\Auth\RegisterController;
use WezomCms\Users\Http\Controllers\Site\Auth\ResetPasswordByCodeController;
use WezomCms\Users\Http\Controllers\Site\Auth\ResetPasswordController;
use WezomCms\Users\Http\Controllers\Site\Auth\SocialAuthController;
use WezomCms\Users\Http\Controllers\Site\Auth\VerificationController;
use WezomCms\Users\Http\Controllers\Site\CabinetController;

// Auth
Route::name('auth.')->group(function () {
    // Registration Routes...
//    Route::get('register/form', [RegisterController::class, 'showRegistrationForm'])->name('register-form');
//    Route::post('register', [RegisterController::class, 'register'])->name('register');

    // Authentication Routes...
//    Route::get('login/form', [LoginController::class, 'showLoginForm'])->name('login-form');
//    Route::post('login', [LoginController::class, 'login'])->name('login');
    //Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // Password Reset Routes...
    Route::prefix('password')->name('password.')->group(function () {
//        Route::get('popup', [ForgotPasswordController::class, 'showPopup'])->name('popup');
//        Route::post('reset', [ForgotPasswordController::class, 'sendResetLink'])->name('reset');

        // Reset by email
        Route::get('reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('reset-form');
        Route::post('update', [ResetPasswordController::class, 'reset'])->name('update');

        // Reset by code
//        Route::get('reset-by-code/{id}', [ResetPasswordByCodeController::class, 'showResetForm'])
//            ->name('reset-by-code-form')
//            ->where('id', '\d+');
//        Route::post('update-by-code', [ResetPasswordByCodeController::class, 'reset'])->name('update-by-code');
    });

    // Account Verification Routes...
    Route::name('verification.')->group(function () {
        Route::get('account/verify', [VerificationController::class, 'show'])->name('notice');
        Route::get('account/verify-email/{id}', [VerificationController::class, 'verify'])
            ->name('verify')
            ->where('id', '\d+');
        Route::get('account/resend', [VerificationController::class, 'resend'])->name('resend');
        Route::post('account/verify-phone', [VerificationController::class, 'verifyPhone'])->name('verify-phone');
    });

    // Socialite
    Route::prefix('socialite')->name('socialite')->group(function () {
        Route::get('{driver}/redirect', [SocialAuthController::class, 'redirect']);
        Route::get('{driver}/callback', [SocialAuthController::class, 'callback'])
            ->name('.callback');
        Route::get('{id}/disconnect', [SocialAuthController::class, 'disconnect'])
            ->name('.disconnect')
            ->where('id', '\d+');
    });
});

// Cabinet
Route::prefix('cabinet')->name('cabinet')->middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('', [CabinetController::class, 'index']);
        Route::post('logout', [CabinetController::class, 'logout'])->withoutMiddleware('verified')->name('.logout');
    });
