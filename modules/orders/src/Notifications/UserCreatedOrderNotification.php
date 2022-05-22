<?php

namespace WezomCms\Orders\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use WezomCms\Orders\Models\Order;
use WezomCms\Users\Models\User;

class UserCreatedOrderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var Order
     */
    private $order;

    /**
     * Create a new notification instance.
     *
     * @param  Order  $order
     */
    public function __construct(Order $order)
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
        return ['mail'];
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
            ->subject(__('cms-orders::site.email.Thank you for your order!'))
            ->markdown('cms-orders::site.notifications.created-order', [
                'order' => $this->order,
                'deliveryInformation' => $this->order->deliveryInformation,
                'urlToCabinet' => $notifiable instanceof User ? route('cabinet') : null,
            ]);
    }
}
