@php
    /**
     * @var $product \WezomCms\Catalog\Models\Product
     * @var $gallery \Illuminate\Support\Collection|\WezomCms\Catalog\Models\ProductImage[]|string[]
     */
@endphp
<div class="product-gallery"
     x-data="{isVideoActive: false}"
>
        <div class="product-gallery__thumbs">
            @if($gallery->isNotEmpty())
                <div class="gallery-thumb-slider js-dmi" data-slider="product-gallery-thumbs">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        @foreach($gallery as $image)
                            @if($image instanceof \WezomCms\Catalog\Models\ProductImage)
                                <div class="gallery-thumb-slider__slide swiper-slide"
                                     @click="isVideoActive = false"
                                >
                                    <img class="swiper-lazy"
                                         src="{{ url('images/core/no-image.svg') }}"
                                         data-src="{{ $image->getImageUrl('small') }}"
{{--                                         alt="{{ $image->altAttribute($product, $loop->iteration) }}"--}}
                                         title="{{ $image->titleAttribute($product, $loop->iteration) }}">
                                    <div class="swiper-lazy-preloader"></div>
                                </div>
                            @else
                                <div class="gallery-thumb-slider__slide swiper-slide"
                                     @click="isVideoActive = true"
                                >
                                    <img class="swiper-lazy"
                                         data-src="{{ \WezomCms\Core\Foundation\Helpers::getYoutubePoster($image, 'sddefault') }}"
{{--                                         alt="{{ $image }}"--}}
                                         title="{{ $image }}"
                                    >
                                    @svg('common', 'youtube', 40, 'gallery-thumb-slider__slide-icon')
                                    <div class="swiper-lazy-preloader"></div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="slider-button slider-button--prev js-slider-prev">
                        <div class="arrow-button arrow-button--theme-transparent">
                            @svg('common', 'arrow-left', [8, 14])
                        </div>
                    </div>
                    <div class="slider-button slider-button--next js-slider-next">
                        <div class="arrow-button arrow-button--theme-transparent">
                            @svg('common', 'arrow-right', [8, 14])
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    <div class="product-gallery__preview">
        <div class="product-gallery__preview-inner">
            <div class="gallery-preview-slider {{ $gallery->isNotEmpty() ? 'js-dmi' : '' }}"
                 data-slider="product-gallery" data-mfp="gallery">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        @forelse($gallery as $image)
                            @if($image instanceof \WezomCms\Catalog\Models\ProductImage)
                                <div class="swiper-slide">
                                    <div class="gallery-preview-slider__img"
                                    >
                                        <img class="swiper-lazy"
                                             src="{{ $image->getImageUrl('big') }}"
                                             data-src="{{ $image->getImageUrl('big') }}"
{{--                                             alt="{{ $image->altAttribute($product, $loop->iteration) }}"--}}
                                             title="{{ $image->titleAttribute($product, $loop->iteration) }}">
                                    </div>
                                    <div class="swiper-lazy-preloader"></div>
                                </div>
                            @else
                                <div class="swiper-slide _flex _items-center">
                                    <div class="gallery-preview-slider__img gallery-preview-slider__img--iframe">
                                        <iframe
                                            width="1120"
                                            height="630"
                                            src="{{\WezomCms\Core\Foundation\Helpers::getYoutubeEmbed($image) }}"
                                            frameborder="0"
                                            allowfullscreen
                                        ></iframe>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <div class="swiper-slide">
                                <img src="{{ $product->getImageUrl('big') }}" alt="{{ $product->name }}">
                            </div>
                        @endforelse
                    </div>
                </div>
                <div class="product-gallery__labels"
                     :hidden="isVideoActive"
                >
                    @widget('catalog:product-labels', ['product' => $product])
                </div>
            </div>
        </div>
        <div class="_mb-md _lg:mb-df _df:show">
            <div class="text _fz-xs _color-faint-strong">
                @if($specifications)
                    @foreach($specifications as $name => $specification)
                        {{ $name . ': ' . collect($specification['values'])->pluck('name')->implode(', ') . ($loop->remaining ? ' / ' : '') }}
                    @endforeach
                @endif
            </div>
        </div>
        <div class="_df:show">
            <button type="button"
                    class="link link--all-results link--theme-gray link--no-decoration"
                    @click="$dispatch('opentab', 'characteristics'); $dispatch('scroll', 'characteristics')"
            >
            <span class="link__text text _fz-sm">
                @lang('cms-catalog::site.Все характеристики')
            </span>
                <span class="link__icon">
                @svg('common', 'arrow-right', [11, 11])
            </span>
            </button>
        </div>
    </div>
</div>
