<?php

namespace WezomCms\Contacts\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use WezomCms\Contacts\Models\Contact;

class ContactNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var Contact
     */
    private $contact;

    /**
     * Create a new notification instance.
     *
     * @param  Contact  $contact
     */
    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->subject(__('cms-contacts::admin.New message from the contact form'))
            ->markdown('cms-contacts::admin.notifications.email', [
                'contact' => $this->contact,
                'urlToAdmin' => route('admin.contacts.edit', $this->contact->id),
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'route_name' => 'admin.contacts.edit',
            'route_params' => $this->contact->id,
            'icon' => 'fa-envelope-o',
            'color' => 'info',
            'heading' => __('cms-contacts::admin.Contacts'),
            'description' => __('cms-contacts::admin.New message from the contact form'),
        ];
    }
}
