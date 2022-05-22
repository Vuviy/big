{{--@php--}}
{{--    /**--}}
{{--     * @var $product \WezomCms\Catalog\Models\Product--}}
{{--     */--}}
{{--@endphp--}}

{{--<img src="{{ $product->getImageUrl('small') }}" alt="{{ $product->name }}">--}}

{{--<div>{{ $product->name }}</div>--}}

{{--@if($product->availableForPurchase())--}}
{{--    <div>@lang('cms-catalog::site.Есть в наличии')</div>--}}
{{--@else--}}
{{--    <div>@lang('cms-catalog::site.Нет в наличии')</div>--}}
{{--@endif--}}

{{--<div>@lang('cms-catalog::site.Артикул'): {{ $product->vendor_code }}</div>--}}

{{--<div>--}}
{{--    <div>@money($product->cost, true)</div>--}}
{{--    @if($product->sale && $product->old_cost)--}}
{{--        <span>@money($product->old_cost)</span>--}}
{{--        <small>{{ money()->siteCurrencySymbol() }}</small>--}}
{{--        <div>@lang('cms-catalog::site.Скидка'): {{ $product->discount_percent }}% (@money($product->discountCostDistinction, true))</div>--}}
{{--    @endif--}}
{{--</div>--}}

{{--<div>--}}
{{--    --}}{{--<livewire:orders.product-button :product="$product" :key="uniqid()"/>--}}

{{--    <livewire:buy-one-click.product-button :product="$product"  :key="'buy-one-click.product-button:' . $product->id"/>--}}

{{--    <livewire:favorites.product-button :favorable="$product" :key="'favorites.product-button:' . $product->id"/>--}}
{{--</div>--}}
