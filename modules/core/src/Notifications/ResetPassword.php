<?php

namespace WezomCms\Core\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as BaseResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends BaseResetPassword
{
    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->subject(__('cms-core::admin.auth.Reset Password Notification'))
            ->line(__('cms-core::admin.auth.Reset password receive text1'))
            ->action(
                __('cms-core::admin.auth.Reset Password'),
                url(config('app.url') . route('admin.password.reset-form', [
                    'token' => $this->token,
                    'email' => $notifiable->getEmailForPasswordReset()
                ], false))
            )
            ->line(__('cms-core::admin.auth.This password reset link will expire in :count minutes', ['count' => config('auth.passwords.' . config('auth.defaults.passwords') . '.expire')]))
            ->line(__('cms-core::admin.auth.If you did not request a password reset no further action is required'));
    }
}
