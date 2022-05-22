<?php

namespace WezomCms\Credit\Http\Controllers\Site;

use Illuminate\Http\Request;
use WezomCms\Credit\Contracts\CreditBankSendsRequestsInterface;
use WezomCms\Credit\Services\CreditService;
use WezomCms\Orders\Models\Order;

class HomeCreditController
{
    /**
     * @param  Request  $request
     * @param  CreditService  $creditService
     */
    public function __invoke(Request $request, CreditService $creditService)
    {
        logger(__CLASS__ . __METHOD__, [
            'request' => $request->all(),
            'Content-Type' => $request->getContentType(),
            'Accept' => $request->getAcceptableContentTypes(),
            'Content' => $request->getContent(),
        ]);

        if ($request->input('authkey') !== settings('home-credit.site.auth_key')) {
            logger()->warning('Home credit authkey doesnt match', $request->only('authkey'));

            abort(404);
            return;
        }

        $orderId = $request->input('orderNo');

        $order = Order::find($orderId);
        if (!$order) {
            logger()->warning('Order doesnt exists', ['order_id' => $orderId]);

            abort(404);
            return;
        }

        $bank = $creditService->getPayment($order->paymentInformation->bank);

        if (!$bank) {
            logger()->warning('Cant find credit bank', ['order_id' => $orderId]);

            abort(404);
            return;
        }

        if (!$bank instanceof CreditBankSendsRequestsInterface) {
            logger()->warning('Bank doesnt instanceof CreditBankSendsRequestsInterface', [
                'order_id' => $orderId,
                'bank' => $bank::getType(),
            ]);

            abort(404);
            return;
        }

        $bank->saveBankRequest($order, $request->all());
    }
}
