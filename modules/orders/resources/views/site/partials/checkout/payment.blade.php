@php
    /**
     * @var $payments \WezomCms\Orders\Models\Payment[]|\Illuminate\Database\Eloquent\Collection
     * @var $paymentId int|null
     * @var $selectedPayment \WezomCms\Orders\Models\Payment|null
     */
    $selectedPayment = $paymentId ? $payments->firstWhere('id', $paymentId) : null;

    $selectedPaymentDriver = $selectedPayment ? $selectedPayment->makeDriver() : null;
@endphp
<div class="_mb-md _lg:mb-df">
    <div class="_grid _spacer _spacer--sm _items-center _mb-none">
        <div class="_cell">
            <div class="step-counter">
                <div class="text _color-white">3</div>
            </div>
        </div>
        <div class="_cell">
            <div class="text _fz-def _fw-bold _color-black">@lang('cms-orders::site.Оплата')</div>
        </div>
    </div>
    <div class="box box--checkout @if($errors->has('paymentId')) box--has-error @endif">
        @foreach($payments as $payment)
            <?php $paymentDriver = $payment->makeDriver(); ?>

            <div class="@if(!$loop->last) _mb-sm @endif">
                <div class="radio-button">
                    <input class="radio-button__control"
                           @if($paymentDriver && !$paymentDriver->available())
                           disabled
                           @endif
                           id="paymentId-{{ $payment->id }}"
                           type="radio"
                           name="paymentId"
                           wire:model.debounce.150ms="paymentId"
                           wire:key="paymentId-{{ $payment->id }}"
                           wire:loading.attr="disabled"
                           value="{{ $payment->id }}"
                           @if($loop->last) checked @endif
                    >
                    <label class="radio-button__label" for="paymentId-{{ $payment->id }}">
                        <span class="radio-button__checkmark _mr-xs"></span>
                        <span class="radio-button__text text _fz-xs _color-pantone-gray">
                            {{ $payment->name }}
                        </span>
                    </label>
                </div>
            </div>
        @endforeach
        @error('paymentId')
            <div class="form-item__error _mt-sm">{{ $message }}</div>
        @enderror

        @if($selectedPaymentDriver instanceof \WezomCms\Orders\Contracts\Payment\HasCheckoutFieldsInterface)
            {!! $selectedPaymentDriver->renderFormInputs($this) !!}
        @endif
    </div>
</div>
