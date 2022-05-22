<?php

namespace WezomCms\Orders\Contracts\Payment;

use Illuminate\Http\Request;
use WezomCms\Orders\Models\Order;

interface OnlinePaymentInterface
{
    /**
     * Generate link to payment system.
     *
     * @param  Order  $order
     * @return string|null
     */
    public function redirectUrl(Order $order): ?string;

    /**
     * Handle server request from payment system.
     *
     * @param  Order  $order
     * @param  Request  $request
     * @return bool - is successfully payed
     */
    public function handleServerRequest(Order $order, Request $request): bool;
}
