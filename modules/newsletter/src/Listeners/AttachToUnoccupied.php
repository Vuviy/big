<?php

namespace WezomCms\Newsletter\Listeners;

use Illuminate\Auth\Events\Login;
use WezomCms\Newsletter\Services\UserSubscription;

class AttachToUnoccupied
{
    /**
     * @param  Login  $login
     */
    public function handle(Login $login)
    {
        if ($login->user->email) {
            UserSubscription::attachToUnoccupied($login->user);
        }
    }
}
