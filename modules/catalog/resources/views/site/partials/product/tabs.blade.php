@php
    /**
     * @var $product \WezomCms\Catalog\Models\Product
     * @var $specifications Illuminate\Support\Collection
     * @var $countReviews int
     */
@endphp

<div class="tabs"
     x-data="app.alpine.tabs({ container: 'tabsContainer', nowOpen: 'details' })"
     @opentab="open($event.detail)"
     @scroll="scroll($event.detail)"
     x-init="$watch('nowOpen', () => setTimeout(() => $parent.resize(), 300)); moveUnderline()"
>
    <div class="_flex _items-center _mb-sm _md:mb-md">
        <div class="_mr-sm">
            @include('cms-product-reviews::site.partials.rating', ['rating' => $product->rating])
        </div>
        <div class="reviews-info"
             title="{{ $countReviews }} {{ trans_choice('cms-catalog::site.отзыв|отзыва|отзывов', $countReviews) }}"
             @click="open('reviews', 'button-reviews')"
        >
            <div class="text _mr-xs">
                {{ $countReviews }} {{ trans_choice('cms-catalog::site.отзыв|отзыва|отзывов', $countReviews) }}
            </div>
            @svg('common', 'dialogue', [16, 16], 'reviews-info__icon')
        </div>
    </div>
    <div class="tabs__header _mb-xs"
         x-ref="tabsHeader"
    >
        <div class="tabs__header-inner">
            <button class="tabs__button button"
                    type="button"
                    @click="open('details')"
                    :class="{ 'is-active': isOpen('details') }"
                    x-ref="button-details"
            >
            <span class="button__text _fz-xs">
                @lang('cms-catalog::site.Все о товаре')
            </span>
            </button>
            <button class="tabs__button button"
                    type="button"
                    @click="open('characteristics')"
                    :class="{ 'is-active': isOpen('characteristics') }"
                    x-ref="button-characteristics"
            >
            <span class="button__text _fz-xs">
                @lang('cms-catalog::site.Характеристики')
            </span>
            </button>
            <button class="tabs__button button"
                    type="button"
                    @click="open('reviews')"
                    :class="{ 'is-active': isOpen('reviews') }"
                    x-ref="button-reviews"
            >
            <span class="button__text _fz-xs">
                @lang('cms-catalog::site.Отзывы :count', ['count' => $countReviews])
            </span>
            </button>
            @if($accessories->isNotEmpty())
                <button class="tabs__button button"
                        type="button"
                        @click="open('accessories')"
                        :class="{ 'is-active': isOpen('accessories') }"
                        x-ref="button-accessories"
                >
                <span class="button__text _fz-xs">
                    @lang('cms-catalog::site.Аксессуары')
                </span>
                </button>
            @endif
        </div>
        <div class="tabs__bottom-line" x-ref="underline"></div>
    </div>
    <div class="tabs__body _mb-xs"
         x-ref="tabsContainer"
    >
        <div class="tabs__body-inner">
            <div class="card-grid _mb-df _lg:mb-xxl"
                 :class="{ 'card-grid--transformed': !isOpen('details') }"
            >
                <div class="card-grid__col">
                    <div class="tabs__block"
                         x-ref="details"
                         x-show="isOpen('details')"
                    >
                        @include('cms-catalog::site.partials.product.tabs.info')
                    </div>
                    <div class="tabs__block"
                         x-ref="characteristics"
                         x-show="isOpen('characteristics')"
                    >
                        @include('cms-catalog::site.partials.product.tabs.characteristics')
                    </div>
                    <div class="tabs__block"
                         x-ref="reviews"
                         x-show="isOpen('reviews')"
                    >
                        @include('cms-catalog::site.partials.product.tabs.reviews')
                    </div>
                    @if($accessories->isNotEmpty())
                        <div class="tabs__block"
                             x-ref="accessories"
                             x-show="isOpen('accessories')"
                        >
                            @include('cms-catalog::site.partials.product.tabs.accessories')
                        </div>
                    @endif
                </div>
                <div class="card-grid__col">
                    @include('cms-catalog::site.partials.product.info')
                </div>
            </div>
            <div class="tabs__block"
                 x-ref="details"
                 x-show="isOpen('details')"
            >
                <div class="_mb-df _lg:mb-xxl">
                    @if(!empty($product->text))
                        <div class="wysiwyg js-import" data-wrap-media data-draggable-table>
                            {!! $product->text !!}
                        </div>
                    @endif
                </div>
                @include('cms-catalog::site.partials.product.tabs.reviews')
            </div>
        </div>
    </div>
</div>
