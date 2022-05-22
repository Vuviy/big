<?php

namespace WezomCms\Favorites\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use WezomCms\Users\Models\User;

class SyncFavorites
{
    /**
     * @param  Registered|Login|Verified  $event
     */
    public function handle($event)
    {
        if (
            $event->user instanceof User
            && (!$event->user instanceof MustVerifyEmail || $event->user->hasVerifiedEmail())
        ) {
            $manager = app('favorites');

            foreach ($manager->driver('cookie')->getAll() as $favorable) {
                $manager->driver('database')->add($favorable);
            }

            $manager->driver('cookie')->clear();
        }
    }
}
