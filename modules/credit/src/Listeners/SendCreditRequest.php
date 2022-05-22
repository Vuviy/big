<?php

namespace WezomCms\Credit\Listeners;

use WezomCms\Orders\Contracts\Payment\MustSendRequestToService;
use WezomCms\Orders\Events\CreatedOrder;

class SendCreditRequest
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CreatedOrder  $event
     * @return void
     */
    public function handle(CreatedOrder $event)
    {
        $driver = $event->order->getOnlinePaymentDriver();
        if (!$driver || !$driver instanceof MustSendRequestToService) {
            return;
        }

        $driver->sendRequestToService($event->order);
    }
}
