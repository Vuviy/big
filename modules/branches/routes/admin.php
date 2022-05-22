<?php

use WezomCms\Branches\Http\Controllers\Admin\BranchesController;

Route::adminResource('branches', BranchesController::class)->settings();
