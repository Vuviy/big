<?php


use WezomCms\Contacts\Http\Controllers\Admin\ContactsController;

Route::adminResource('contacts', ContactsController::class)->settings();
