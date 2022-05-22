@php
    /**
     * @var $item WezomCms\Catalog\Models\Product
     */

    $isFavoritesPage = $isFavoritesPage ?? false;
@endphp

<div class="product-card">
    <div class="product-card__header">
        <div class="product-card__labels">
            @widget('catalog:product-labels', ['product' => $item])
        </div>
        <div class="product-card__favorite">
            @widget('favorites:product-list-button', ['product' => $item, 'showFavoritesCheck' => $isFavoritesPage])
        </div>
    </div>
    <div class="product-card__body">
        <a href="{{ $item->getFrontUrl() }}" class="product-card__gallery">
            @if($item->images->isEmpty())
                <span class="product-card__image">
                    <img src="{{ $item->getImageUrl('medium', 'image', 'images') }}" alt="{{ $item->name }}">
                </span>
            @else
                @foreach($item->images->take(2) as $image)
                    <span class="product-card__image">
                    <img src="{{ $image->getImageUrl('medium') }}" alt="{{ $item->name }}">
                </span>
                @endforeach
            @endif
        </a>
        <div class="product-card__rating">
            <div class="rating">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= (int)round($item->rating))
                        @svg('common', 'star', 12, 'rating__star is-active')
                    @else
                        @svg('common', 'star', 12,'rating__star')
                    @endif
                @endfor
            </div>
            <a href="{{ $item->getFrontUrl() }}" class="reviews-info" title="{{ trans_choice('cms-catalog::site.отзыв|отзыва|отзывов', $item->published_reviews_count) }}">
                <span class="text _mr-xs">
                    {{ $item->published_reviews_count }}
                </span>
                @svg('common', 'dialogue', [16, 16], 'reviews-info__icon')
            </a>
        </div>
    </div>
    <div class="product-card__footer">
        <a href="{{ $item->getFrontUrl() }}" class="product-card__name text _fz-xs">
            {{ $item->name }}
        </a>
        <div class="_flex _items-center _justify-between">
            <a href="{{ $item->getFrontUrl() }}" class="product-card__price text _fz-def _fw-bold">
                {{ money($item->cost, true) }}
                @if($item->sale && $item->old_cost)
                    <span class="product-card__old-price _fz-xs _color-pantone-gray">@money($item->old_cost, true)</span>
                @endif
            </a>
            <livewire:orders.product-list-button :product="$item" :key="uniqid('orders.product-list-button:' . $item->id)" />
        </div>
    </div>
</div>
