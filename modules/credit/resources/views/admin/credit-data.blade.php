@php
    /**
     * @var $storage \WezomCms\Orders\Models\OrderPaymentInformation
     * @var $order \WezomCms\Orders\Models\Order
     * @var $banks array
     */
@endphp
<div class="row">
    <div class="col-md-4">
        <dl>
            <dt>@lang('cms-credit::admin.Credit bank')</dt>
            <dd>{{ $storage->bank ? array_get($banks, $storage->bank, __('cms-core::admin.layout.Not set')) : __('cms-core::admin.layout.Not set')}}</dd>
        </dl>
    </div>
    <div class="col-md-4">
        <dl>
            <dt>@lang('cms-credit::admin.IPN')</dt>
            <dd>{{ $storage->ipn ?? __('cms-core::admin.layout.Not set') }}</dd>
        </dl>
    </div>
    <div class="col-md-4">
        <dl>
            <dt>@lang('cms-credit::admin.Repayment period')</dt>
            <dd>{{ $storage->repayment_period ?? __('cms-core::admin.layout.Not set') }}</dd>
        </dl>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <dl>
            <dt>@lang('cms-credit::admin.Bank application number')</dt>
            <dd>{{ $storage->bank_order_no ?? __('cms-core::admin.layout.Not set') }}</dd>
        </dl>
    </div>
    <div class="col-md-4">
        <dl>
            <dt>@lang('cms-credit::admin.Bank agreement number')</dt>
            <dd>{{ $storage->bank_contract_code ?? __('cms-core::admin.layout.Not set') }}</dd>
        </dl>
    </div>
    <div class="col-md-4">
        <dl>
            <dt>@lang('cms-credit::admin.Status of the application in the bank')</dt>
            <dd>{{ $storage->bank_status ?? __('cms-core::admin.layout.Not set') }}</dd>
        </dl>
    </div>
</div>
