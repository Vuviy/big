@php
    /**
     * @var $product \WezomCms\Catalog\Models\Product
     * @var $inCart bool
     * @var $buttonClass string|null
     * @var $availableForPurchase bool
     */
@endphp
<div class="_flex _flex-grow">
    @if($availableForPurchase)
        <button type="button"
                class="button button--theme-yellow _b-r-sm _control-height-md _control-padding-xs _control-space-xs _flex-grow {{ $inCart ? 'is-active' : '' }} {{ $buttonClass }}"
                x-data
                x-on:click="$dispatch('set-appbar-cart-name','cart')"
                wire:click="addToCart"
                wire:loading.attr="disabled"
                title="{{ $inCart ? __('cms-orders::site.Открыть корзину') : __('cms-orders::site.Добавить в корзину') }}"
        >
            <span class="button__text _fz-sm">
                {{ $inCart ? __('cms-orders::site.В корзине') : __('cms-orders::site.В корзину') }}
            </span>
            <span class="button__icon button__icon--right">
                @svg('common', 'cart-stroke', [20, 20])
            </span>
        </button>
    @else
        <button type="button"
                class="button button--theme-gray _b-r-sm _control-height-md _control-padding-xs _control-space-xs _flex-grow"
                disabled="disabled"
        >
            <span class="button__text _fz-sm">
                @lang('cms-orders::site.Нет в наличии')
            </span>
        </button>
    @endif
</div>
