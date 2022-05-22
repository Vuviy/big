<?php

namespace WezomCms\Users\Http\Livewire;

use Auth;
use Livewire\Component;
use WezomCms\Core\Foundation\JsResponse;
use WezomCms\Core\Services\CheckForSpam;

/**
 * Class Modal
 * @package WezomCms\Users\Http\Livewire
 */
class EmailConfirmation extends Component
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function render()
    {
        return view('cms-users::site.livewire.email-confirmation');
    }

    /**
     * Resend email verification link
     */
    public function resend(CheckForSpam $checkForSpam)
    {
        if (!$checkForSpam->checkInComponent($this) || !Auth::check()) {
            return;
        }

        Auth::user()->sendEmailVerificationNotification();

        JsResponse::make()
            ->success(true)
            ->notification(__('cms-users::site.auth.A fresh verification link has been sent to your email address'))
            ->emit($this);
    }
}
