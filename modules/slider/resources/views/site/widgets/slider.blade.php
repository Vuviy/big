@php
    /**
     * @var $result \Illuminate\Database\Eloquent\Collection|\WezomCms\Slider\Models\Slide[]
     */
@endphp

@if(count($result))
    @push('preload')
        <link rel="preload" as="image" media="(max-width: 480px)" href="{{ $result->first()->getImageUrl('medium') }}">
        <link rel="preload" as="image" media="(min-width: 480px)" href="{{ $result->first()->getImageUrl('medium', 'image_mobile') }}">
    @endpush
@endif

<div class="section section--bg-black">
    <div class="main-slider js-dmi" data-slider="main">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                @foreach($result as $obj)
                    <div class="swiper-slide">
                        <div class="main-slider__slide">
                            <div class="container">
                                <div class="main-slider__slide-bg">
                                    <img class="swiper-lazy _sm:show" src="{{ $obj->getImageUrl('medium') }}"
                                         alt="{{ $obj->name }}">
                                    <img class="swiper-lazy _sm:hide" src="{{ $obj->getImageUrl('medium', 'image_mobile') }}"
                                         alt="{{ $obj->name }}">
                                </div>
                                <div class="main-slider__slide-content">
                                    <div class="_grid _justify-center _sm:justify-between _spacer _spacer--sm _sm:spacer--lg">
                                        <div class="_cell _cell--12 _sm:cell--auto _lg:cell--4 _text-center _sm:text-left">
                                            @if(!empty($obj->description_1))
                                                <div class="main-slider__title text _fz-xxl _fw-bold _color-white">
                                                    {!! $obj->description_1 !!}
                                                </div>
                                            @endif
                                            @if(!empty($obj->url))
                                                <div class="_sm:show">
                                                    <a href="{{ $obj->url }}"
                                                       title="@lang('cms-slider::site.Подробнее')"
                                                       class="button button--theme-yellow _b-r-sm _control-height-md _control-padding-md"
                                                       @if($obj->open_in_new_tab) target="_blank" @endif
                                                    >
                                                <span class="button__text">
                                                    @lang('cms-slider::site.Подробнее')
                                                </span>
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="_cell _cell--12 _sm:cell--auto _lg:cell--3 _sm:flex _sm:justify-end _text-center _sm:text-right">
                                            <div class="_sm:pt-md">
                                                @if(!empty($obj->description_2))
                                                    <div class="text _fz-def _color-white _mb-sm _md:mb-lg">
                                                        {!! $obj->description_2 !!}
                                                    </div>
                                                @endif
                                                @if(!empty($obj->price))
                                                    <div class="text _fz-xxl _fw-bold _color-white _mb-sm">
                                                        @money($obj->price, true)
                                                    </div>
                                                @endif
                                                @if(!empty($obj->url))
                                                    <div class="_sm:hide">
                                                        <a href="{{ $obj->url }}"
                                                           title="@lang('cms-slider::site.Подробнее')"
                                                           class="button button--theme-yellow _b-r-sm _control-height-md _control-padding-md"
                                                           @if($obj->open_in_new_tab) target="_blank" @endif
                                                        >
                                                            <span class="button__text">
                                                                @lang('cms-slider::site.Подробнее')
                                                            </span>
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-lazy-preloader"></div>
                    </div>
                @endforeach
            </div>
            <div class="slider-pagination"></div>
        </div>
    </div>
</div>
