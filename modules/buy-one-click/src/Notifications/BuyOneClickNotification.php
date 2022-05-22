<?php

namespace WezomCms\BuyOneClick\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use WezomCms\BuyOneClick\Models\BuyOneClick;

class BuyOneClickNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var BuyOneClick
     */
    private $order;

    /**
     * Create a new notification instance.
     *
     * @param  BuyOneClick  $order
     */
    public function __construct(BuyOneClick $order)
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
            ->subject(__('cms-buy-one-click::admin.email.New buy one click order'))
            ->markdown('cms-buy-one-click::admin.notifications.email', [
                'order' => $this->order,
                'urlToAdmin' => route('admin.buy-one-click.edit', $this->order->id),
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

        return [
            'route_name' => 'admin.buy-one-click.edit',
            'route_params' => $order->id,
            'icon' => 'fa-rocket',
            'color' => 'warning',
            'heading' => __('cms-buy-one-click::admin.Buy one click'),
            'description' => $order->name . '. ' . $order->phone . ' (' . $order->product->name . ')',
        ];
    }
}
