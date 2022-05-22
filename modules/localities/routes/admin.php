<?php

use WezomCms\Localities\Http\Controllers\Admin\CityController;
use WezomCms\Localities\Http\Controllers\Admin\LocalityController;

Route::adminResource('localities', LocalityController::class);
Route::adminResource('cities', CityController::class);
