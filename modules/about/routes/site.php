<?php

use WezomCms\About\Http\Controllers\Site\AboutController;

Route::get('about', AboutController::class)->name('about');
