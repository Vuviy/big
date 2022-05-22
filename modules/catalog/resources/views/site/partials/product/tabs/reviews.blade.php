<div class="_mb-md _lg:mb-df">
    <div class="text _fz-xl _fw-bold">
        @lang('cms-catalog::site.Отзывы покупателей') {{$product->name}}
    </div>
</div>
<div class="_mb-md _lg:mb-df">
    <div class="box box--rating">
        <div class="_grid _spacer _spacer--df _items-center _justify-center _md:justify-start">
            <div class="_cell">
                <div class="rating-counter">
                    <div class="rating-counter__block">
                        <div class="text _fz-xxl _fw-bold">{{ $product->rating }}</div>
                    </div>
                    @php($ratingDescription = \WezomCms\ProductReviews\Enums\Ratings::asSelectArray())
                    @if(!empty($ratingDescription[$productRating]))
                        <div class="rating-counter__block">
                            <div class="text _fw-bold">
                                {{ __($ratingDescription[$productRating]) }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="_cell">
                <div class="_flex _spacer _spacer--sm _items-center">
                    @include('cms-product-reviews::site.partials.rating', ['rating' => $product->rating, 'classes' => 'rating--xl'])
                    <div class="text _color-pantone-gray">
                        {{ $countReviews }} {{ trans_choice('cms-catalog::site.отзыв|отзыва|отзывов', $countReviews) }}
                    </div>
                </div>
            </div>
            <div class="_cell _md:ml-auto">
                <button
                    type="button"
                    class="button button--theme-transparent-bordered _b-r-sm _control-height-md _control-padding-md _control-space-xs _flex-grow"
                    x-data="app.alpine.openModal('product-reviews.form', {{ json_encode(['productId' => $product->id]) }})"
                    @click="open"
                    @mouseenter="open"
                >
                <span class="button__text">
                    @lang('cms-product-reviews::site.Оставить отзыв')
                </span>
                </button>
            </div>
        </div>
    </div>
</div>
<div class="_mb-md _lg:mb-df">
    @php($jsReviewsListClass = uniqid('js-reviews-list'))
    <div class="{{ $jsReviewsListClass }}">
        @include('cms-catalog::site.partials.product.reviews-list', ['reviews' => $viewReviews])
    </div>
</div>
@if($viewReviews->hasMorePages())
    <div class="_flex _justify-center">
        <button class="button button--theme-transparent _control-height-md _control-padding-xs _control-space-md"
                type="button"
                data-load-more="{{ json_encode([
                    'route' => route('catalog.product.reviews-more', ['product_id' => $viewReviews->first()->product_id, 'page' => $viewReviews->currentPage() + 1]),
                    'appendTo' => '.' . $jsReviewsListClass,
                    'replaceRoute' => false
                ]) }}"
        >
            <span class="button__icon button__icon--left">
                @svg('common', 'arrow-update', [23, 23])
            </span>
            <span class="button__text">
                @lang('cms-core::site.Показать еще')
            </span>
        </button>
    </div>
@endif
