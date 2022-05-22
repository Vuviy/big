@php
    /**
     * @var $bank \WezomCms\Credit\Banks\HomeCreditBank
     * @var $orderPaymentInformation \WezomCms\Orders\Models\OrderPaymentInformation
     */
@endphp

<div>
    @if(Gate::allows('orders.edit', $orderPaymentInformation->order))
        @if($bank->canSendDeliveredStatus($orderPaymentInformation))
            <button data-order-payment-information-id="{{ $orderPaymentInformation->id }}"
                    data-status="{{ \WezomCms\Credit\Enums\HomeCreditApplicationStatuses::DELIVERED }}"
                    class="btn btn-sm btn-primary m-1"
                    type="button"
                    id="home-credit-send-delivered-status-button"
            >
                <i class="fa fa-sign-out"></i>
                <span class="hidden-sm-down">@lang('cms-credit::admin.Hand over the goods to the buyer')</span>
            </button>
        @endif
        @if($bank->canSendCanceledStatus($orderPaymentInformation))
            <button data-order-payment-information-id="{{ $orderPaymentInformation->id }}"
                    data-status="{{ \WezomCms\Credit\Enums\HomeCreditApplicationStatuses::PARTNER_CANCELLED }}"
                    class="btn btn-sm btn-danger m-1 js-home-credit-send-cancelled-status"
                    type="button"
                    id="home-credit-send-canceled-status-button"
            >
                <i class="fa fa-times"></i>
                <span class="hidden-sm-down">@lang('cms-credit::admin.Cancel loan application')</span>
            </button>
        @endif
    @endif
</div>
