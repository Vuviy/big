<?php

use WezomCms\Pages\Http\Controllers\Site\PageController;

Route::get('page/{slug}', PageController::class)->name('page.inner');
