<?php

namespace WezomCms\Orders\Observers;

use Notification;
use WezomCms\Orders\Models\Order;
use WezomCms\Orders\Notifications\OrderStatusChangedNotification;

class OrderObserver
{
    /**
     * @param  Order  $order
     */
    public function updated(Order $order)
    {
        if ($order->wasChanged('status_id')) {
            Notification::send($order->user ?: $order->client, new OrderStatusChangedNotification($order));
        }
    }
}
