<?php

use WezomCms\Contacts\Http\Controllers\Site\ContactsController;

Route::get('contacts', ContactsController::class)->name('contacts');
