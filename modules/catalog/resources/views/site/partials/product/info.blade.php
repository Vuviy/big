@php
    /**
     * @var $product \WezomCms\Catalog\Models\Product
     * @var $variations \Illuminate\Support\Collection|\WezomCms\Catalog\Models\Product[]
     */
@endphp

<div class="_pt-df">
    <div class="_grid _flex-nowrap _spacer _spacer--sm _mb-none">
        <div class="_cell"
             hidden
             :hidden="isOpen('details')"
        >
            <div class="image image--product-preview">
                <img src="{{ $product->getImageUrl('small') }}"
                     width="72"
                     height="96"
                     alt="{{ $product->name }}"
                >
            </div>
        </div>
        <div class="_cell _flex-grow"
             :class="{ '_cell--12': isOpen('details') }"
        >
            <div class="text _fz-xs _color-base-strong _mb-sm"
                 hidden
                 :hidden="isOpen('details')"
            >
                {{ SEO::getH1() }}
            </div>
            <div class="_flex _justify-between _items-center">
                @if($product->availableForPurchase())
                    <div class="_flex _items-center">
                        <div class="icon icon--availability is-active _mr-xs">
                            @svg('common', 'checkmark', 12)
                        </div>
                        <div class="text _color-success">
                            @lang('cms-catalog::site.Есть в наличии')
                        </div>
                    </div>
                @else
                    <div class="_flex _items-center">
                        <div class="icon icon--availability _mr-xs">
                            @svg('common', 'minus', 16)
                        </div>
                        <div class="text _color-pantone-gray">
                            @lang('cms-catalog::site.Нет в наличии')
                        </div>
                    </div>
                @endif
                @if(!empty($product->vendor_code))
                    <div class="text _color-black">
                        <span class="_fz-xxxs">@lang('cms-catalog::site.Артикул'):</span>
                        <span class="text _color-faint-strong _fz-xxxs">
                    {{ $product->vendor_code }}
                </span>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div :class="{ '_hide': !isOpen('details') }">
        @include('cms-catalog::site.partials.product.variations')
    </div>
    <hr class="separator separator--horizontal">
    <div class="_grid _items-center _spacer _spacer--sm _pt-df _mb-none">
        <div class="_cell">
            <div class="text _fz-xl _fw-bold">@money($product->cost, true)</div>
        </div>

        @if($product->sale && $product->old_cost)
            <div class="_cell _mr-auto">
                <div class="text _fz-xs _color-pantone-gray _line-through">
                    @money($product->old_cost, true)
                </div>
            </div>
            <div class="_cell">
                <div class="text _fz-xs _color-critic-strong">
                    @lang('cms-catalog::site.Скидка'): {{ $product->discount_percent }}% (@money($product->discountCostDistinction, true))
                </div>
            </div>
        @endif
    </div>

    <div class="_grid _spacer _spacer--sm _mb-none">
        <div class="_cell"
             :class="{ '_cell--6 _lg:cell--5': isOpen('details'), '_cell--12': !isOpen('details') }"
        >
            <livewire:orders.product-button :product="$product" :key="uniqid('orders.product-button:' . $product->id)"/>
        </div>
        <div class="_cell"
             :class="{ '_cell--6 _lg:cell--5': isOpen('details'), '_cell--10': !isOpen('details') }"
        >
            <livewire:buy-one-click.product-button :product="$product"  :key="uniqid('buy-one-click.product-button:' . $product->id)"/>
        </div>
        <div class="_cell _cell--2">
            <livewire:favorites.product-button :favorable="$product" :key="uniqid('favorites.product-button:' . $product->id)"/>
        </div>
        <div class="_cell"
             :class="{ '_cell--10': isOpen('details'), '_hide': !isOpen('details') }"
        >
        @if($monthlyPayment)
            <livewire:credit.product-button :product="$product" :key="uniqid('credit.product-button:' . $product->id)"/>
        @endif
        </div>
    </div>
    <div :class="{ '_hide': !isOpen('details') }">
        @include('cms-catalog::site.partials.product.delivery-and-payment')
    </div>
</div>
