@php
    /**
     * @var $order \WezomCms\Orders\Models\Order|null
     * @var $storage \WezomCms\Orders\Models\OrderPaymentInformation
     * @var $banks array
     */
@endphp
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('paymentInformation[bank]', __('cms-credit::admin.Credit bank')) !!}
            {!! Form::select('paymentInformation[bank]', $banks, old('paymentInformation.bank', $storage->bank), ['placeholder' => __('cms-core::admin.layout.Not set')]) !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('paymentInformation[ipn]', __('cms-credit::admin.IPN')) !!}
            {!! Form::text('paymentInformation[ipn]', old('paymentInformation.ipn', $storage->ipn)) !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('paymentInformation[repayment_period]', __('cms-credit::admin.Repayment period')) !!}
            {!! Form::number('paymentInformation[repayment_period]', old('paymentInformation.repayment_period', $storage->repayment_period)) !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('paymentInformation[bank_order_no]', __('cms-credit::admin.Bank application number')) !!}
            {!! Form::text('paymentInformation[bank_order_no]', old('paymentInformation.bank_order_no', $storage->bank_order_no), ['disabled' => 'disabled']) !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('paymentInformation[bank_contract_code]', __('cms-credit::admin.Bank agreement number')) !!}
            {!! Form::text('paymentInformation[bank_contract_code]', old('paymentInformation.bank_contract_code', $storage->bank_contract_code), ['disabled' => 'disabled']) !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('paymentInformation[bank_status]', __('cms-credit::admin.Status of the application in the bank')) !!}
            {!! Form::text('paymentInformation[bank_status]', old('paymentInformation.bank_status', $storage->bank_status), ['disabled' => 'disabled']) !!}
        </div>
    </div>
</div>
@if($bank = $storage->makeBank())
    @if(is_a($bank, \WezomCms\Credit\Contracts\CreditBankSendsStatusesToBankInterface::class))
        {!! $bank->renderAdminFormStatusChangingButtons($storage) !!}
    @endif
@endif
