<?php

namespace WezomCms\Callbacks\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use WezomCms\Callbacks\Models\Callback;

class CallbackNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var Callback
     */
    private $order;

    /**
     * Create a new notification instance.
     *
     * @param  Callback  $order
     */
    public function __construct(Callback $order)
    {
        $this->order = $order;
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
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->subject(__('cms-callbacks::admin.email.New callback order'))
            ->markdown('cms-callbacks::admin.notifications.email', [
                'order' => $this->order,
                'urlToAdmin' => route('admin.callbacks.edit', $this->order->id),
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
            'route_name' => 'admin.callbacks.edit',
            'route_params' => $this->order->id,
            'icon' => 'fa-phone',
            'color' => 'success',
            'heading' => __('cms-callbacks::admin.Callback'),
            'description' => implode('. ', array_filter([$this->order->phone])),
        ];
    }
}
