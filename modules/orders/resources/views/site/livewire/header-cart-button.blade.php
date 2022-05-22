@php
    /**
     * @var $count int
     */
@endphp
<div>
    <button
       class="header-button"
       @if($count) title="@lang('cms-orders::site.Открыть корзину')" @endif
       x-data="app.alpine.openModal('orders.cart-popup')"
       x-on:click="forceOpen($event);$dispatch('set-appbar-cart-name','cart')"
    >
        <span class="header-button__icon icon">
            @svg('common', 'cart-stroke', 20)
        </span>
        @if($count)
            <span class="header-button__counter">
                <span class="text _fz-xs _color-black">{{ $count }}</span>
            </span>
        @endif
    </button>
</div>
