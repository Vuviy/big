<?php

namespace WezomCms\Users\Listeners;

use Illuminate\Support\Facades\Notification;
use WezomCms\Users\Events\AutoRegistered;
use WezomCms\Users\Notifications\AutoGeneratedPassword;

/**
 * Class SendAutoGeneratedPasswordNotification
 *
 * @package WezomCms\Users\Listeners
 */
class SendAutoGeneratedPasswordNotification
{
    /**
     * Handle the event.
     *
     * @param  AutoRegistered  $event
     * @return void
     */
    public function handle(AutoRegistered $event)
    {
        Notification::send($event->user, new AutoGeneratedPassword($event->password));
    }
}
