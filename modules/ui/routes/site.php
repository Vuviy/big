<?php

use WezomCms\Ui\Http\Controllers\NotFoundController;

if (app()->isLocal()) {
    Route::view('ui-kit', 'cms-ui::ui-kit');
}

Route::view('render-component', 'cms-ui::component')->name('render-component');

Route::fallback(NotFoundController::class);
