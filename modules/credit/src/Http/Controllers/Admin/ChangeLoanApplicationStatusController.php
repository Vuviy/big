<?php

namespace WezomCms\Credit\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use WezomCms\Orders\Models\OrderPaymentInformation;

class ChangeLoanApplicationStatusController extends Controller
{
    public function __invoke(OrderPaymentInformation $orderPaymentInformation, string $status)
    {
        $bank = $orderPaymentInformation->makeBank();
        if (isset($bank)) {
            $bank::sendStatusToBank($orderPaymentInformation, $status);
        }
    }
}
