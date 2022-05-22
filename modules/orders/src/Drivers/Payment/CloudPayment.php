<?php

namespace WezomCms\Orders\Drivers\Payment;

use Http;
use Illuminate\Http\Request;
use WezomCms\Orders\Contracts\ExpectsResponse;
use WezomCms\Orders\Contracts\Payment\OnlinePaymentInterface;
use WezomCms\Orders\Contracts\PaymentDriverInterface;
use WezomCms\Orders\Models\Order;

class CloudPayment implements PaymentDriverInterface, OnlinePaymentInterface, ExpectsResponse
{
    protected const FIND_PAYMENT_URL = 'https://api.cloudpayments.ru/v2/payments/find';

    /**
     * Generate link to payment system.
     *
     * @param  Order  $order
     * @return string|null
     */
    public function redirectUrl(Order $order): ?string
    {
        return route('cloud-payment', $order->id);
    }

    /**
     * Handle server request from payment system.
     *
     * @param  Order  $order
     * @param  Request  $request
     * @return bool - is successfully payed
     */
    public function handleServerRequest(Order $order, Request $request): bool
    {
        $publicId = settings('payments.cloud-payment.public_id');
        $apiSecret = settings('payments.cloud-payment.api_secret');

        if (empty($publicId) || empty($apiSecret)) {
            return false;
        }

        $response = Http::withBasicAuth($publicId, $apiSecret)
            ->asJson()
            ->acceptJson()
            ->post(static::FIND_PAYMENT_URL, ['invoiceId' => $order->id]);

        if ($response->status() !== 200) {
            return false;
        }

        return data_get($response->json(), 'Success', false);
    }

    public function available(): bool
    {
        return !empty(settings('payments.cloud-payment.public_id')) && !empty(settings('payments.cloud-payment.api_secret'));
    }

    public function successResponse(Order $order)
    {
        return response()->json(['success' => true, 'message' => 'Ok'], 200);
    }

    public function failedResponse(Order $order)
    {
        return response()->json(['success' => false, 'message' => "Payment wasn't handled"], 200);
    }
}
