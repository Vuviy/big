@php
    /**
     * @var $product \WezomCms\Catalog\Models\Product|\WezomCms\Orders\Contracts\PurchasedProductInterface
     */
@endphp

<div class="_flex _flex-grow">
    @if($product->availableForPurchase())
        <button type="button"
                class="button button--theme-transparent-bordered _b-r-sm _control-height-md _control-padding-xs _control-space-xs _flex-grow"
                x-data="app.alpine.openModal('buy-one-click.form', {{ json_encode(['id' => $product->id]) }})"
                x-on:click="open"
                x-on:mouseenter="open"
        >
            <span class="button__text _fz-sm">
                @lang('cms-buy-one-click::site.Купить в 1 клик')
            </span>
        </button>
    @else
        <button type="button"
                class="button button--theme-transparent-bordered _b-r-sm _control-height-md _control-padding-xs _control-space-xs _flex-grow"
                disabled
        >
            <span class="button__text _fz-sm">
                @lang('cms-buy-one-click::site.Купить в 1 клик')
            </span>
        </button>
    @endif
</div>
