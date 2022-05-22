@php
    /**
     * @var $order \WezomCms\Orders\Models\Order
	 * @var $paymentData array
     * @var $rangeBreakpoints \Illuminate\Support\Collection
     * @var $banks \Illuminate\Support\Collection|\WezomCms\Credit\Bank[]
     * @var $cartTotal int
     * @var $monthlyPayment int
	 */
@endphp
<div class="_lg:pl-md _lg:pr-xl _pt-sm">
    <div class="text _fz-sm _color-base-strong _letter-spacing-def _mb-sm">@lang('cms-credit::site.Выберите банк')</div>
    <div class="_mb-sm">
        @foreach($banks as $bank)
            <label class="pay-bank @if(!$loop->last) _mb-sm @endif" for="paymentData.bank">
                <input class="visually-hidden pay-bank__input"
                       id="paymentData.bank"
                       type="radio"
                       wire:model="paymentData.bank"
                       wire:key="paymentData.bank"
                       value="{{ $bank->type }}"
                >
                <span class="pay-bank__inner">
                    <span class="pay-bank__logo">
                        @if($bank->logo)
                            <img src="{{ $bank->logo }}" alt="{{ $bank->name }}">
                        @endif
                    </span>
                    <span class="text _fz-xs _color-base-strong">{{ $bank->name }}</span>
                    @if($bank->label)
                        <span class="pay-bank__label text _fz-xxxs _fw-bold _color-success _text-center">{{ $bank->label }}</span>
                    @endif
                    @if($bank->monthlyPayment)
                        <span class="text _fz-def _fw-bold _color-base-strong _text-right">@money($bank->monthlyPayment, true)/@lang('cms-credit::site.мес')</span>
                    @endif
                </span>
                <span class="pay-bank__badge">
                @svg('common', 'check', [14, 10])
            </span>
            </label>
        @endforeach
    </div>
    <div class="_grid _xs:grid--2 _md:grid--1 _lg:grid--2 _spacer _spacer--sm _mb-none">
        <div class="_cell">
            <div class="form-item form-item--select2 _control-height-md _control-padding-xxs _fz-xs">
                @php($inputId = uniqid('bank-input'))
                <div class="form-item__header">
                    <label for="{{ $inputId }}" class="form-item__label _text _fz-xxxs _color-faint-strong">
                        @lang('cms-credit::site.Срок погашения') (@lang('cms-credit::site.мес').):
                    </label>
                </div>

                <select
                    class="js-dmi js-select select-input"
                    name="paymentData.repayment_period"
                    wire:model="paymentData.repayment_period"
                    wire:key="paymentData.repayment_period"
                    id="{{ $inputId }}"
                >
                    @foreach($rangeBreakpoints as $month)
                        <option value="{{ $month }}">{{ $month }}</option>
                    @endforeach
                </select>
                @error('deliveryData.saved_address_id')
                    <label id="{{ $inputId }}-error" class="form-item__error" for="{{ $inputId }}">{{ $message }}</label>
                @enderror
            </div>
        </div>
        <div class="_cell">
            @component('cms-ui::components.form.input', [
                'name' => 'paymentData.ipn',
                'attributes' => [
                    'wire:model.lazy=paymentData.ipn',
                    'wire:key=paymentData.ipn',
                ],
                'label' => __('cms-credit::site.Введите Ваш ИИН') . '*',
                'classes' => 'form-item--theme-white _control-height-md _control-padding-xxs',
                'type' => 'text',
                'errors' => $errors,
                'placeholder' => __('cms-credit::site.Номер ИИН')
            ])@endcomponent
        </div>
    </div>
    <div class="text _fz-sm _color-base-strong _letter-spacing-def _mb-xs">
        @lang('cms-credit::site.Условия покупки:')
    </div>
    <div class="_flex _justify-between _items-center _mb-xs">
        <div class="text _fz-xxs _color-black _flex-grow">@lang('cms-credit::site.Сумма')</div>
        <div class="text _fz-xxs _color-base-strong _fw-bold _ml-sm">@money($cartTotal, true)</div>
    </div>
    <div class="_flex _justify-between _items-center _mb-xs">
        <div class="text _fz-xxs _color-black _flex-grow">@lang('cms-credit::site.Количество платежей')</div>
        <div class="text _fz-xxs _color-base-strong _fw-bold _ml-sm">{{ $paymentData['repayment_period'] }}</div>
    </div>
    <div class="_flex _justify-between _items-center">
        <div class="text _fz-xxs _color-black _flex-grow">@lang('cms-credit::site.Ежемесячный платеж')</div>
        <div class="text _fz-xxs _color-base-strong _fw-bold _ml-sm">@money($monthlyPayment, true)</div>
    </div>
</div>
