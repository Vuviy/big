<?php

namespace WezomCms\Orders\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use WezomCms\Core\Models\Administrator;
use WezomCms\Orders\Models\Order;

class CreatedOrderNotification extends Notification implements ShouldQueue
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
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed|Administrator  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        $routeName = $notifiable->hasAccess('orders.edit') ? 'admin.orders.edit' : 'admin.orders.show';

        return (new MailMessage())
            ->subject(__('cms-orders::admin.email.New order'))
            ->markdown('cms-orders::admin.notifications.created-order', [
                'order' => $this->order,
                'payment' => $this->order->payment ? $this->order->payment->name : '',
                'urlToAdmin' => route($routeName, $this->order->id),
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
        $order = $this->order;
        $client = $this->order->client;

        return [
            'route_name' => 'admin.orders.edit',
            'route_params' => $order->id,
            'icon' => 'fa-rocket',
            'color' => 'warning',
            'heading' => __('cms-orders::admin.email.New order'),
            'description' => sprintf(
                '%s %s',
                $client->full_name,
                $client->phone
            ),
        ];
    }
}
