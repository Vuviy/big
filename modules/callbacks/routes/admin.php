<?php

use WezomCms\Callbacks\Http\Controllers\Admin\CallbacksController;

Route::adminResource('callbacks', CallbacksController::class)->settings();
