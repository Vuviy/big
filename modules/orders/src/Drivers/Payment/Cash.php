<?php

namespace WezomCms\Orders\Drivers\Payment;

use WezomCms\Orders\Contracts\PaymentDriverInterface;

class Cash implements PaymentDriverInterface
{
    public const KEY = 'cash';

    public function available(): bool
    {
        return true;
    }
}
