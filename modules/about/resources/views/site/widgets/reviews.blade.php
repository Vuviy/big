@php
    /**
     * @var $result \Illuminate\Support\Collection|\WezomCms\About\Models\AboutReview[]
     */
@endphp

<div class="container container--md">
    <div class="about-reviews">
        <div class="about__title _md:py-df _df:py-lg _my-df _df:my-lg">
    <span>
        @lang('cms-about::site.История успеха и')<br>
        @lang('cms-about::site.Наша команда')
    </span>
            @svg('common', 'team-item-decor', [237, 270])
        </div>

        <div class="about-reviews__slider js-dmi" data-slider="our-reviews">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @foreach($result as $review)
                        <div class="swiper-slide">
                            <div class="about-reviews__slide">
                                <div class="about-reviews__slide-text">{{ $review->text }}</div>
                                <div class="about-reviews__slide-title">{{ $review->name }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="slider-button slider-button--horizontal slider-button--prev js-slider-prev">
                <div class="arrow-button arrow-button--theme-default">
                    @svg('common', 'arrow-left', [8, 14])
                </div>
            </div>
            <div class="slider-button slider-button--horizontal slider-button--next js-slider-next">
                <div class="arrow-button arrow-button--theme-default">
                    @svg('common', 'arrow-right', [8, 14])
                </div>
            </div>
            <div class="slider-pagination"></div>
        </div>

        <livewire:about.review-form />
    </div>
</div>

