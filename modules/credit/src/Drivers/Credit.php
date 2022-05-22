<?php

namespace WezomCms\Credit\Drivers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use WezomCms\Credit\Bank;
use WezomCms\Credit\Banks\HomeCreditBank;
use WezomCms\Credit\Contracts\CreditBankInterface;
use WezomCms\Credit\Services\CreditService;
use WezomCms\Orders\Contracts\CartItemInterface;
use WezomCms\Orders\Contracts\Payment\HasCheckoutFieldsInterface;
use WezomCms\Orders\Contracts\Payment\MustSendRequestToService;
use WezomCms\Orders\Contracts\Payment\OnlinePaymentInterface;
use WezomCms\Orders\Contracts\PaymentDriverInterface;
use WezomCms\Orders\Http\Livewire\Checkout;
use WezomCms\Orders\Models\Order;
use WezomCms\Orders\Models\OrderPaymentInformation;

class Credit implements PaymentDriverInterface, HasCheckoutFieldsInterface, OnlinePaymentInterface, MustSendRequestToService
{
    public const DRIVER = 'credit';

    /**
     * @var CreditService
     */
    protected $creditService;

    /**
     * Credit constructor.
     * @param  CreditService  $creditService
     */
    public function __construct(CreditService $creditService)
    {
        $this->creditService = $creditService;
    }

    /**
     * @param  Checkout  $checkout
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function renderFormInputs(Checkout $checkout)
    {
        if ($deliveryData = session('checkout-payment')) {
            if ($repaymentPeriod = array_get($deliveryData, 'repayment_period')) {
                $checkout->paymentData['repayment_period'] = $repaymentPeriod;
            }

            if ($selectedBank = array_get($deliveryData, 'bank')) {
                $checkout->paymentData['bank'] = $selectedBank;
            }
        }

        $cartTotal = \Cart::total();

        $items = collect(\Cart::content())->map(function (CartItemInterface $cartItem) {
            return [
                'product' => $cartItem->getPurchaseItem(),
                'price' => $cartItem->getTotal(),
                'quantity' => $cartItem->getQuantity()
            ];
        });

        $rangeBreakpoints = $this->creditService->getPayments()
            ->map(function (CreditBankInterface $service) use ($items, $cartTotal) {
                return $service->monthCount($items, $cartTotal);
            })->flatten()->unique()->sort();

        $repaymentPeriod = array_get($checkout->paymentData, 'repayment_period');

        if (!$rangeBreakpoints->contains($repaymentPeriod)) {
            $repaymentPeriod = $rangeBreakpoints->first();

            $checkout->paymentData['repayment_period'] = $repaymentPeriod;
        }

        // If month range is empty - dont render component.
        if ($rangeBreakpoints->isEmpty()) {
            return '<div></div>';
        }

        $banks = $this->creditService->getPayments()
            ->map(function (CreditBankInterface $service) use ($items, $repaymentPeriod) {
                return $service->bank($items, $repaymentPeriod);
            })->filter();

        // If for current cart doesn't match any bank - don't render component.
        if ($banks->isEmpty()) {
            return '<div></div>';
        }

        /** @var Bank $selectedBank */
        $selectedBank = $banks->firstWhere('type', array_get($checkout->paymentData, 'bank')) ?? $banks->first();

        $checkout->paymentData['bank'] = $selectedBank->type;

        return view('cms-credit::site.credit', [
            'paymentData' => $checkout->paymentData,
            'rangeBreakpoints' => $rangeBreakpoints,
            'banks' => $banks,
            'cartTotal' => $cartTotal,
            'monthlyPayment' => $selectedBank->monthlyPayment,
        ]);
    }

    /**
     * Get validation rules.
     *
     * @return array
     */
    public function getValidationRules(): array
    {
        return [
            [
                'repayment_period' => 'required|int|min:1',
                'bank' => [
                    'required',
                    'string',
                    Rule::in(HomeCreditBank::getType())
                ],
                'ipn' => ['required', 'digits:12'],
            ],
            [],
            [
                'repayment_period' => __('cms-credit::site.Срок погашения'),
                'bank' => __('cms-credit::site.Банк'),
                'ipn' => __('cms-credit::site.ИИН'),
            ],
        ];
    }

    /**
     * Fill database storage.
     *
     * @param  OrderPaymentInformation  $storage
     * @param  array  $data
     */
    public function fillStorage(OrderPaymentInformation $storage, array $data)
    {
        $storage->fill([
            'ipn' => array_get($data, 'ipn'),
            'repayment_period' => array_get($data, 'repayment_period'),
            'bank' => array_get($data, 'bank'),
        ]);
    }

    /**
     * @param  OrderPaymentInformation  $storage
     * @param  Order|null  $order
     * @return mixed
     */
    public function renderAdminFormInputs(OrderPaymentInformation $storage, ?Order $order = null)
    {
        return view('cms-credit::admin.credit', compact('storage', 'order'))->with('banks', $this->banks());
    }

    /**
     * @param  OrderPaymentInformation  $storage
     * @param  Order|null  $order
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function renderAdminFormData(OrderPaymentInformation $storage, ?Order $order = null)
    {
        return view('cms-credit::admin.credit-data', compact('storage', 'order'))->with('banks', $this->banks());
    }

    /**
     * @return array
     */
    protected function banks(): array
    {
        $banks = [];
        foreach ([HomeCreditBank::getType()] as $bank) {
            $banks[$bank] = \Lang::get("cms-credit::admin.$bank");
        }

        return $banks;
    }

    /**
     * @param  Order  $order
     * @return mixed
     */
    public function sendRequestToService(Order $order)
    {
        $payment = app(CreditService::class)->getPayment($order->paymentInformation->bank);

        if (!$payment) {
            logger()->error('Credit payment doesnt exists', ['bank' => $order->paymentInformation->bank]);
            return null;
        }

        return $payment->sendRequestToService($order);
    }

    /**
     * Generate link to payment system.
     *
     * @param  Order  $order
     * @return string|null
     */
    public function redirectUrl(Order $order): ?string
    {
        $payment = app(CreditService::class)->getPayment($order->paymentInformation->bank);

        if (!$payment) {
            logger()->error('Credit payment doesnt exists', ['bank' => $order->paymentInformation->bank]);
            return null;
        }

        return $payment->redirectUrl($order);
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
        return true;
    }

    public function available(): bool
    {
        $cartTotal = \Cart::total();

        $items = collect(\Cart::content())->map(function (CartItemInterface $cartItem) {
            return [
                'product' => $cartItem->getPurchaseItem(),
                'price' => $cartItem->getTotal(),
                'quantity' => $cartItem->getQuantity()
            ];
        });

        $rangeBreakpoints = $this->creditService->getPayments()
            ->map(function (CreditBankInterface $service) use ($items, $cartTotal) {
                return $service->monthCount($items, $cartTotal);
            })->flatten()->unique()->sort();

        // If month range is empty - dont render component.
        if ($rangeBreakpoints->isEmpty()) {
            return false;
        }

        return true;
    }
}
