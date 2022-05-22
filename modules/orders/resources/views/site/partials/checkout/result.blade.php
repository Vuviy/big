<div class="sticky-block sticky-block--checkout">
    <div>
        <div class="_grid _justify-between _spacer _spacer--sm _mb-none">
            <div class="_cell">
                <div class="text _fz-xxs _fw-bold _uppercase">
                    @lang('cms-orders::site.Товары в заказе')
                </div>
            </div>
            <div class="_cell">
                <button class="link link--all-results link--theme-gray link--no-decoration"
                        type="button"
                        x-data="app.alpine.openModal('orders.cart-popup', {{ json_encode(['checkoutPage' => true]) }})"
                        x-on:click="open"
                        x-on:mouseenter="open"
                >
                    <span class="link__text text _fz-sm">
                        @lang('cms-orders::site.редактировать')
                    </span>
                    <span class="link__icon">
                        @svg('common', 'arrow-right', [11, 11])
                    </span>
                </button>
            </div>
        </div>
        <div class="checkout-list">
            @foreach($cart['items'] as $item)
                @php($product = $item['product'])
                <div class="checkout-list__item">
                    <div class="_flex _items-center _flex-noshrink">
                        <a href="{{ $product->getFrontUrl() }}" title="{{ $product->name }}" class="checkout-list__item-image">
                            <img src="{{ $product->getImageUrl('small') }}" alt="{{ $product->name }}">
                        </a>
                    </div>
                    <div class="_flex _flex-column _justify-center">
                        <a class="link link--no-decoration link--theme-base-strong _fz-xs _color-base-strong _mb-xs"
                           href="{{ $product->getFrontUrl() }}">
                            {{ $product->name }}
                        </a>
                        @if($product->sale)
                            <div class="_flex">
                                <div class="text _fz-xs _color-pantone-gray">
                                    <span>@money($product->cost, true)</span>
                                    <span class="_mx-xs">×</span>
                                    <span>{{ $item['quantity']['value'] }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="_flex _items-center _flex-noshrink">
                        <div class="_flex _flex-column _flex-grow _text-right">
                            @if($product->sale && $product->old_cost)
                                <span class="text _fz-def _color-base-strong _fw-bold">@money($product->cost, true)</span>
                                <span class="text _fz-xs _color-pantone-gray _line-through">@money($product->old_cost, true)</span>
                            @else
                                <span class="text _fz-def _color-base-strong _fw-bold">@money($product->cost, true)</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <hr class="separator separator--horizontal separator--offset-md">
        <div>
            <div class="_flex _items-center _justify-between">
                <div class="text _fz-xs _color-base-strong">{{ $cart['items_quantity'] }} {{ trans_choice('cms-orders::site.товар|товара|товаров', $cart['items_quantity']) }} @lang('cms-orders::site.на')</div>
                <div class="text _fz-xs _color-base-strong _text-right">@money($cart['sub_total'], true)</div>
            </div>

            @if($delivery && $deliveryCost > 0)
                <div class="_flex _items-center _justify-between">
                    <div class="text _fz-xs _color-base-strong">@lang('cms-orders::site.Стоимость доставки')</div>
                    <div class="text _fz-xs _color-base-strong _text-right">@money($deliveryCost, true)</div>
                </div>
            @endif

            <hr class="separator separator--horizontal separator--offset-md">
            <div class="_flex _items-center _justify-between">
                <div class="text _fz-xl _color-base-strong _fw-bold">@lang('cms-orders::site.Итого к оплате')</div>
                <div class="text _fz-xl _color-black _fw-bold _text-right">@money($cart['total'], true)</div>
            </div>
        </div>
        <hr class="separator separator--horizontal separator--offset-md">
    </div>

    <div class="_mt-lg _mb-sm _flex">
        <button type="submit"
                class="button button--theme-yellow _control-height-md _b-r-sm _flex-grow"
                form="checkout-form"
                wire:loading.attr="disabled"
                wire:target="send"
                @if($hasUnavailableProducts) disabled @endif
        >
            <span class="button__text">@lang('cms-orders::site.Заказ подтверждаю')</span>
        </button>
    </div>

    @if($hasUnavailableProducts)
        <div class="box box--inform _my-md">
            <div class="_flex _justify-between _items-center">
                <div class="text _fz-xs _color-critic-strong">@lang('cms-orders::site.В корзине есть товар, которого нет в наличии')</div>
                <button class="link link--all-results link--theme-base-strong link--no-decoration"
                        type="button"
                        x-data="app.alpine.openModal('orders.cart-popup', {{ json_encode(['checkoutPage' => true]) }})"
                        x-on:click="open"
                        x-on:mouseenter="open"
                >
                    <span class="link__text text _fz-sm">
                        @lang('cms-orders::site.редактировать')
                    </span>
                    <span class="link__icon">
                        @svg('common', 'arrow-right', [11, 11])
                    </span>
                </button>
            </div>
        </div>
    @endif

    <div class="_flex _flex-column _items-center">
        <span class="_flex _flex-column _items-center">
            <span class="text _fz-xs _color-black">@lang('cms-users::site.Нажимая на кнопку, ты соглашаешься с')</span>

            <a href="{{ route('privacy-policy') }}" target="_blank" rel="noopener" class="link _fz-xs _color-pantone-gray _underline">
                <span class="link__text">
                    @lang('cms-users::site.пользовательским соглашением')
                </span>
            </a>
        </span>
    </div>
</div>
