@php
    /**
     * @var $availableforPurchase bool
     * @var $inCart bool
     */
@endphp
<div>
    @if($availableForPurchase)
        <button class="button product-card__button {{ $inCart ? 'is-active' : '' }} _b-r-sm"
                x-data
                x-on:click="$dispatch('set-appbar-cart-name','cart')"
                wire:click="addToCartOrOpenModal"
                wire:key="enabled-cart-product-list-button-{{ $productId }}"
                title="{{ $inCart ? __('cms-orders::site.Открыть корзину') : __('cms-orders::site.Добавить в корзину') }}">
                @if($inCart)
                    @svg('common', 'cart-stroke', 20)
                @else
                    @svg('common', 'cart-stroke', 20)
                @endif
        </button>
    @else
        <button disabled
                wire:key="disabled-cart-product-list-button-{{ $productId }}">
        </button>
    @endif
</div>
