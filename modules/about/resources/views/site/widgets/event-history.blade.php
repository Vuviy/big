@php
    /**
     * @var $result \Illuminate\Support\Collection
     */
@endphp

<div class="about__title _md:py-df _df:py-lg _my-df _df:my-lg">
    <span>
        @lang('cms-about::site.История успеха и')<br>
        @lang('cms-about::site.Наша команда')
    </span>
    @svg('common', 'team-item-decor', [237, 270])
</div>

<div class="_my-df _df:mb-lg _df:pb-lg _df:px-lg">
    <div class="about-history__slider about-history__slider--years js-dmi _my-md _df:mb-lg" data-slider="our-history-years">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                @foreach($result as $year => $events)
                    <div class="swiper-slide">
                        <div class="about-history__year">
                            {{ $year }}
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
    <div class="about-history__slider js-dmi" data-slider="our-history">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                @foreach($result as $year => $events)
                    <div class="swiper-slide">
                        <div class="about-history__slide">
                            <div class="about-history__slide-title">{{ $year }}</div>

                            @foreach($events as $event)
                                <div class="about-history__slide-event">{!! $event->description !!}</div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="slider-pagination"></div>
    </div>
</div>
