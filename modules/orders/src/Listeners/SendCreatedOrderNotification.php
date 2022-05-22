<?php

namespace WezomCms\Orders\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Notification;
use WezomCms\Core\Models\Administrator;
use WezomCms\Orders\Events\CreatedOrder;
use WezomCms\Orders\Notifications\CreatedOrderNotification;
use WezomCms\Orders\Notifications\UserCreatedOrderNotification;

/**
 * Class SendCreatedOrderNotification
 *
 * @package WezomCms\Orders\Listeners
 */
class SendCreatedOrderNotification implements ShouldQueue
{
    /**
     * Handle the event
     *
     * @param  CreatedOrder  $createdOrder
     */
    public function handle(CreatedOrder $createdOrder)
    {
        Notification::send(
            Administrator::toNotifications('orders.edit', 'orders.show')->get(),
            new CreatedOrderNotification($createdOrder->order)
        );

        try {
            if (!empty($createdOrder->order->client->email)) {
                Notification::send($createdOrder->order->client, new UserCreatedOrderNotification($createdOrder->order));
            }
        } catch (\Throwable $e) {
            logger(__CLASS__ . __METHOD__, ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        }
    }
}
