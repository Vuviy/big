<?php

namespace WezomCms\Newsletter\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use WezomCms\Newsletter\Mail\NewsletterMail;

class Newsletter extends Notification implements ShouldQueue
{
    use Queueable;

    private $subject;
    private $text;

    /**
     * Create a new notification instance.
     *
     * @param $subject
     * @param $text
     */
    public function __construct($subject, $text)
    {
        $this->subject = $subject;
        $this->text = $text;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return NewsletterMail
     */
    public function toMail($notifiable)
    {
        return (new NewsletterMail($notifiable, $this->subject, $this->text))
            ->to($notifiable->email);
    }
}
