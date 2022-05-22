<?php

namespace WezomCms\Newsletter\Observers;

use WezomCms\Newsletter\Services\UserSubscription;
use WezomCms\Users\Models\User;

class UserObserver
{
    /**
     * Handle the User "updated" event.
     *
     * @param  User  $user
     * @return void
     */
    public function updated(User $user)
    {
        if ($user->isClean('email')) {
            return;
        }

        UserSubscription::updateOrCreate($user);
    }
}
