<?php

use WezomCms\Newsletter\Http\Controllers\Site\NewsletterController;

Route::get('newsletter/unsubscribe/{token}', [NewsletterController::class, 'unsubscribe'])
    ->name('newsletter.unsubscribe');
