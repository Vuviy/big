<?php

namespace WezomCms\Orders\Contracts;

interface PaymentDriverInterface
{
    public function available(): bool;
}
