@php
    /**
     * @var $content array
     * @var $checkoutPage bool
     * @var $subTotal float|int
     * @var $items array
     */
@endphp
<div class="modal-content modal-content--size-xxxl" x-on:mousedown.away="close">
    <div class="_flex _items-center _justify-between _mb-xs">
        @if(!empty($items))
            <div class="text _fz-xxs _fw-bold _uppercase _color-base-strong">
                @lang('cms-orders::site.Корзина')
            </div>
        @endif
    </div>

    <div class="modal-body">
        @if(!empty($items))
            <div>
                <div class="_mb-sm">
                    @include('cms-orders::site.partials.cart-items')
                </div>
                <div class="_grid _items-center _spacer _spacer--sm">
                    <div class="_cell">
                        <button class="link link--all-results link--theme-gray link--no-decoration"
                                x-on:click="close"
                        >
                            <span class="link__icon">
                                @svg('common', 'arrow-left', [11, 11])
                            </span>
                            <span class="link__text text _fz-sm">
                                @lang('cms-orders::site.Продолжить покупки')
                            </span>
                        </button>
                    </div>
                    <div class="_cell _ml-auto">
                        <div class="text _fz-xl _fw-bold _color-black">@money($subTotal, true)</div>
                    </div>
                    <div class="_cell _cell--12 _sm:cell--auto _flex">
                        <button class="button button--theme-yellow _control-height-md _control-padding-md _b-r-sm _flex-grow"
                                @if($checkoutPage) x-on:click="close" @else wire:click="toCheckout" @endif
                        >
                            <span class="button__text">@lang('cms-orders::site.Оформить заказ')</span>
                        </button>
                    </div>
                </div>
            </div>
        @else
            <div class="_flex _justify-center _mb-sm">
                <img src="{{ url('/images/empty-pages/history.svg') }}" style="max-height: 200px;" alt="">
            </div>
            <div class="text _fz-lg _fw-bold _color-base-strong _text-center _mb-xs">@lang('cms-orders::site.Корзина пуста')</div>
            <div class="text _fz-xxs _color-base-strong _text-center">@lang('cms-orders::site.Добавляйте товары в корзину и покупайте их быстро и удобно')</div>
        @endif
    </div>
</div>
