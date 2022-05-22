<?php

use WezomCms\OurTeam\Http\Controllers\Admin\EmployeesController;

Route::adminResource('employees', EmployeesController::class)->settings();
