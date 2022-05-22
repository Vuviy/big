<?php

use WezomCms\Home\Http\Controllers\Site\HomeController;

Route::get('/', HomeController::class)->name('home');
