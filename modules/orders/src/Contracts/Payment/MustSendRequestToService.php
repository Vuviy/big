<?php

namespace WezomCms\Orders\Contracts\Payment;

use WezomCms\Orders\Models\Order;

interface MustSendRequestToService
{
    /**
     * @param  Order  $order
     * @return mixed
     */
    public function sendRequestToService(Order $order);
}
