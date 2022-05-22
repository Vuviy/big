<?php

namespace WezomCms\Credit\Contracts;

use WezomCms\Orders\Models\Order;

interface CreditBankSendsRequestsInterface
{
    /**
     * @param  Order  $order
     * @param  array  $requestData
     * @return mixed
     */
    public function saveBankRequest(Order $order, array $requestData);
}
