<?php

use WezomCms\Faq\Http\Controllers\Site\FaqController;

Route::get('faq', FaqController::class)->name('faq');
Route::get('faq/load-more/{id}', [FaqController::class, 'loadMore'])->where(['id' => '\d+'])->name('faq.load-more');
