@php
    /**
     * @var $items array
     */
@endphp
<div>
    <div class="cart-list">
        @foreach($items as $item)
            @php
                /** @var \WezomCms\Orders\Contracts\PurchasedProductInterface $product */
                $product = $item['product'];
            @endphp
            <div class="cart-list__item">
                <div class="_flex _items-center _flex-noshrink">
                    <button class="button button--action"
                            wire:loading.attr="disabled"
                            wire:click="removeItem('{{ $item['row_id'] }}')"
                    >
                        <span class="button__icon icon icon--size-xs">
                            @svg('common', 'cross', 15)
                        </span>
                    </button>
                </div>
                <div class="_flex _items-center _flex-noshrink">
                    <a href="{{ $product->getFrontUrl() }}" class="cart-list__item-image">
                        <img src="{{ $product->getImageUrl('small') }}" alt="{{ $product->name }}">
                    </a>
                </div>
                <div class="_flex _flex-noshrink _flex-column _justify-center">
                    <div class="_mb-xs">
                        <a href="{{ $product->getFrontUrl() }}"
                           class="link link--theme-black _fz-sm _color-base-strong _no-underline"
                        >
                            {{ $product->name }}
                        </a>
                    </div>
                    <div class="_grid _items-center _spacer _spacer--xs _mb-none">
                        <div class="_cell">
                            <div class="text _fz-sm _color-black">@money($product->cost, true)</div>
                        </div>
                        <div class="_cell">
                            @if($product->sale && $product->old_cost)
                                <div class="text _fz-xs _color-pantone-gray _line-through">@money($product->old_cost, true)</div>
                            @endif
                        </div>
                    </div>

                    @if(!empty($product->vendor_code))
                        <div class="text _color-black">
                            <span>@lang('cms-catalog::site.Артикул'):</span>
                            <span class="text _color-faint-strong">
                                {{ $product->vendor_code }}
                            </span>
                        </div>
                    @endif
                </div>
                <div class="_flex _items-center _flex-noshrink">
                    <div>
                        @if(!$product->availableForPurchase())
                            <div class=""
                                 title="@lang('cms-orders::site.Товара нет в наличии')">
                                @svg('common', 'close', 20)
                                <span>@lang('cms-orders::site.Нет в наличии')</span>
                            </div>
                        @else
                            <div class="_flex">
                                <div class="_flex _items-center">
                                    <button class="button button--action"
                                            wire:loading.attr="disabled"
                                            wire:click="decreaseCount('{{ $item['row_id'] }}')"
                                            @if(!$product->canDecreaseQuantity($item['quantity']['value'])) disabled @endif
                                    >
                                        <span class="button__icon icon icon--size-md">
                                            @svg('common', 'minus-rounded', 18)
                                        </span>
                                    </button>
                                </div>
                                <div class="_flex _items-center">
                                    <div class="form-item form-item--input form-item--theme-base-weak _control-height-md _control-padding-xxs">
                                        <div class="form-item__body">
                                            <input
                                                type="number"
                                                wire:model.lazy="content.{{ $item['row_id'] }}"
                                                value="{{ $item['quantity']['value'] }}"
                                                min="{{ $item['quantity']['min'] }}"
                                                step="{{ $item['quantity']['step'] }}"
                                                class="form-item__control text _fz-sm _color-black _text-center"
                                            >
                                        </div>
                                    </div>
                                </div>
                                <div class="_flex _items-center">
                                    <button class="button button--action"
                                            wire:loading.attr="disabled"
                                            wire:click="increaseCount('{{ $item['row_id'] }}')"
                                            @if(!$product->canIncreaseQuantity($item['quantity']['value'])) disabled @endif
                                    >
                                        <span class="button__icon icon icon--size-md">
                                            @svg('common', 'plus-rounded', 18)
                                        </span>
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="_flex _flex-noshrink _flex-column _justify-center _items-end">
                    <div class="text _fz-def _color-black _fw-bold">@money($item['sub_total'], true)</div>
                    @if($item['crossed_out_sub_total'] > $item['sub_total'])
                        <div class="text _fz-xs _color-pantone-gray _line-through">@money($item['crossed_out_sub_total'], true)</div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
