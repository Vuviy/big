<?php

namespace WezomCms\Orders\Http\Controllers\Site;

use WezomCms\Core\Http\Controllers\SiteController;
use WezomCms\Orders\Enums\PaymentTypes;
use WezomCms\Orders\Models\Order;

class CloudPaymentController extends SiteController
{
    /**
     * @param $orderId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function __invoke($orderId)
    {
        $order = Order::findOrFail($orderId);

        $this->seo()->setPageName('Cloud Payments');

        if ($order->payed || !$order->payment || $order->payment->driver !== PaymentTypes::CLOUD_PAYMENT) {
            return session('order-id') == $order->id
                ? redirect($order->thanksPageUrl())
                : redirect()->route('home');
        }

        return view('cms-orders::site.payment.cloud-payment', [
            'order' => $order,
            'paymentData' => [
                'publicId' => (string)settings('payments.cloud-payment.public_id'),
                'description' => __('cms-orders::site.checkout.Payment for order :order', ['order' => $order->id]),
                'invoiceId' => (string)$order->id,
                'amount' => $order->whole_purchase_price,
                'currency' => money()->code(),
                'accountId' => $order->client->email,
                'email' => $order->client->email,
                'skin' => 'mini',
            ],
        ]);
    }
}
