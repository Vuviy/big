<?php

use WezomCms\Credit\Http\Controllers\Site\HomeCreditController;

Route::post('home-credit/status', HomeCreditController::class)->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
