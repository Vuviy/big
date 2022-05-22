@php
    /**
     * @var $deliveryId int|null
     * @var $deliveries \Illuminate\Database\Eloquent\Collection|\WezomCms\Orders\Models\Delivery[]
     * @var $selectedDelivery \WezomCms\Orders\Models\Delivery|null
     */

    $selectedDelivery = $deliveryId ? $deliveries->where('id', $deliveryId)->first() : null;
@endphp
<div class="_mb-md _lg:mb-df">
    <div class="_grid _spacer _spacer--sm _items-center _mb-none">
        <div class="_cell">
            <div class="step-counter">
                <div class="text _color-white">2</div>
            </div>
        </div>
        <div class="_cell">
            <div class="text _fz-def _fw-bold _color-black">@lang('cms-orders::site.Доставка')</div>
        </div>
    </div>

    <div class="box box--checkout @if($errors->has('deliveryId')) box--has-error @endif js-dmi" data-delivery>
        @foreach($deliveries as $delivery)
            <div class="@if(!$loop->last) _mb-sm @endif">
                <div class="radio-button">
                    <input class="radio-button__control" id="deliveryId" type="radio" wire:model="deliveryId" value="{{ $delivery->id }}">
                    <label class="radio-button__label" for="deliveryId">
                        <span class="radio-button__checkmark _mr-xs"></span>
                        <span class="radio-button__text text _fz-xs _color-pantone-gray">
                            {{ $delivery->name }}
                        </span>
                    </label>
                </div>
            </div>
        @endforeach

        @error('deliveryId')
            <div class="form-item__error _mt-sm">{{ $message }}</div>
        @enderror

        @if($selectedDelivery && $selectedDeliveryDriver = $selectedDelivery->makeDriver(compact('deliveryData')))
            {!! $selectedDeliveryDriver->renderFormInputs($deliveryData) !!}
        @endif
    </div>
</div>
