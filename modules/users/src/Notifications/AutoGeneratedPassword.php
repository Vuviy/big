<?php

namespace WezomCms\Users\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\TurboSms\TurboSmsChannel;
use NotificationChannels\TurboSms\TurboSmsMessage;
use WezomCms\Users\Models\User;
use WezomCms\Users\Notifications\Channels\ESputnikChannel;

class AutoGeneratedPassword extends Notification
{
    /**
     * Automatically generated password.
     *
     * @var string|int
     */
    private $password;

    /**
     * AutoGeneratedPassword constructor.
     *
     * @param  string  $password
     */
    public function __construct(string $password)
    {
        $this->password = $password;
    }

    /**
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if ($notifiable->registered_through === User::PHONE) {
            switch (config('cms.users.users.sms_service')) {
                case 'turbosms':
                    return [TurboSmsChannel::class];
                case 'esputnik':
                    return [ESputnikChannel::class];
                default:
                    return [];
            }
        } else {
            return ['mail'];
        }
    }

    /**
     * @param  mixed  $notifiable
     * @return TurboSmsMessage
     */
    public function toTurboSms($notifiable)
    {
        return TurboSmsMessage::create(
            __(
                'cms-users::site.auth.Thank you for registration Your password is: :password',
                ['password' => $this->password]
            )
        );
    }

    /**
     * @param  mixed  $notifiable
     * @return string
     */
    public function toESputnik($notifiable)
    {
        return __(
            'cms-users::site.auth.Thank you for registration Your password is: :password',
            ['password' => $this->password]
        );
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->subject(__('cms-users::site.auth.Thank you for registration'))
            ->line(
                __(
                    'cms-users::site.auth.Thank you for registration Your password is: :password',
                    ['password' => $this->password]
                )
            )->action(__('cms-users::site.auth.Personal cabinet'), route('cabinet'));
    }
}
