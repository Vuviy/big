<?php

use WezomCms\PrivacyPolicy\Http\Controllers\Site\PrivacyPolicyController;

Route::get('privacy-policy', PrivacyPolicyController::class)->name('privacy-policy');
