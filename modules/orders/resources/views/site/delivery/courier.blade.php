@php
    /**
     * @var $userAddresses \WezomCms\Orders\Models\UserAddress|\Illuminate\Database\Eloquent\Collection
     * @var $deliveryData array
     */
@endphp

@if($userAddresses->isNotEmpty())
    <div class="form-item form-item--select2 _control-height-md _control-width-select _control-padding-xxs _fz-xs _mt-sm">
        @php($inputId = uniqid('delivery-input'))
        <div class="form-item__header">
            <label for="{{ $inputId }}" class="form-item__label _text _fz-xxxs _color-faint-strong">
                @lang('cms-orders::site.Выберите адрес')
            </label>
        </div>

        <select
            class="js-dmi js-select select-input"
            name="deliveryData.saved_address_id"
            wire:model="deliveryData.saved_address_id"
            wire:key="deliveryData.saved_address_id"
            data-delivery-select
            id="{{ $inputId }}"
        >
            <option value="">@lang('cms-orders::site.Другой')</option>
            @foreach($userAddresses as $userAddress)
                <option value="{{ $userAddress->id }}">{{ $userAddress->full_address }}</option>
            @endforeach
        </select>
        @error('deliveryData.saved_address_id')
            <label id="{{ $inputId }}-error" class="form-item__error" for="{{ $inputId }}">{{ $message }}</label>
        @enderror
    </div>
@endif

<div class="_grid _spacer _spacer--sm _mb-none _mt-sm @if($userAddresses->isNotEmpty()) _hide @endif" data-delivery-fields>
        <div class="_cell _cell--12 _sm:cell--6 _md:cell--12">
            <div class="form-item form-item--select2 _control-height-md _control-width-select _control-padding-xxs _fz-xs">
                @php($inputId = uniqid('delivery-input'))
                <div class="form-item__header">
                    <label for="{{ $inputId }}" class="form-item__label _text _fz-xxxs _color-faint-strong">
                        @lang('cms-orders::site.checkout.Locality')
                    </label>
                </div>

                <select
                    class="js-dmi js-select select-input"
                    name="deliveryData.locality_id"
                    wire:model="deliveryData.locality_id"
                    wire:key="deliveryData.locality_id"
                    id="{{ $inputId }}"
                >
                    <option value="">@lang('cms-core::site.layout.Not set')</option>
                    @foreach($localities as $locality)
                        <option value="{{ $locality->id }}">{{ $locality->city->name . ', ' . $locality->name }}</option>
                    @endforeach
                </select>
                @error('deliveryData.locality_id')
                <label id="{{ $inputId }}-error" class="form-item__error" for="{{ $inputId }}">{{ $message }}</label>
                @enderror
            </div>
            @if(isset($deliveryCost))
                <div class="_flex _spacer _spacer--xs _mt-xs">
                    <div class="_mb-none">
                        @svg('common', 'check', [14, 11])
                    </div>

                    <div class="text _fz-xs _color-base-strong _mb-none">
                        @if($deliveryCost > 0)
                            <span>@money($deliveryCost, true)</span>
                        @else
                            <span>@lang('cms-orders::site.Бесплатно')</span>
                        @endif
                    </div>
                </div>
            @endif
        </div>
        <div class="_cell _cell--12 _sm:cell--6 _md:cell--12 _df:cell--8">
            @component('cms-ui::components.form.input', [
                'name' => 'deliveryData.street',
                'attributes' => [
                    'wire:model.lazy=deliveryData.street',
                    'wire:key=deliveryData.street'
                ],
                'label' => __('cms-orders::site.Улица'),
                'classes' => 'form-item--theme-base-weak _control-height-md _control-padding-xxs',
                'type' => 'text'
            ])@endcomponent
        </div>
        <div class="_cell _cell--12 _sm:cell--6 _md:cell--12 _df:cell--2">
            @component('cms-ui::components.form.input', [
                'name' => 'deliveryData.house',
                'attributes' => [
                    'wire:model.lazy=deliveryData.house',
                    'wire:key=deliveryData.house'
                ],
                'label' => __('cms-orders::site.Дом'),
                'classes' => 'form-item--theme-base-weak _control-height-md _control-padding-xxs',
                'type' => 'text'
            ])@endcomponent
        </div>
        <div class="_cell _cell--12 _sm:cell--6 _md:cell--12 _df:cell--2">
            @component('cms-ui::components.form.input', [
                'name' => 'deliveryData.room',
                'attributes' => [
                    'wire:model.lazy=deliveryData.room',
                    'wire:key=deliveryData.room'
                ],
                'label' => __('cms-orders::site.Квартира'),
                'classes' => 'form-item--theme-base-weak _control-height-md _control-padding-xxs',
                'type' => 'text'
            ])@endcomponent
        </div>
</div>
