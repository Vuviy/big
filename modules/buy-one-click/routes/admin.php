<?php

use WezomCms\BuyOneClick\Http\Controllers\Admin\BuyOneClickController;

Route::adminResource('buy-one-click', BuyOneClickController::class)->settings();
