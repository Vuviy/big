@php
    /**
     * @var $result \Illuminate\Database\Eloquent\Collection|\WezomCms\News\Models\News[]
     */
@endphp
<div class="section section--bg-faint-weak section--off-t-md section--off-b-md section--overflow-hidden">
    <div class="container container--slider-transformed">
        <div class="_grid _justify-between _items-center _spacer _spacer--sm _mb-sm _lg:mb-lg">
            <div class="_cell _cell--auto">
                <div class="text _fz-xl _fw-bold _color-black">
                    @lang('cms-news::site.Акции и новости')
                </div>
            </div>
            <div class="_cell _cell--auto _md:show">
                <a href="{{ route('news') }}" class="link link--all-results link--theme-gray link--no-decoration">
                    <span class="link__text text _fz-sm">
                        @lang('cms-news::site.Все акции и новости')
                    </span>
                    <span class="link__icon">
                        @svg('common', 'arrow-right', [11, 11])
                    </span>
                </a>
            </div>
        </div>
        <div class="news-slider js-dmi" data-slider="news">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @foreach($result as $key => $obj)
                        <div class="swiper-slide">
                            <a href="{{ $obj->getFrontUrl() }}" class="news-slider__slide news-card @if($loop->iteration > 5) _md:show @endif">
                                <span class="news-card__img">
                                    <img class="lazy" src="{{ url('/images/core/no-image.png') }}"
                                         data-src="{{ $obj->getImageUrl() }}" alt="{{ $obj->name }}">
                                </span>
                                <span class="news-card__body">
                                    <span class="news-card__title text _fz-xs _color-black">
                                        {{ $obj->name }}
                                    </span>
                                    <span class="news-card__text text _fz-xxxs _color-faint-strong">
                                        {!! str_limit(strip_tags($obj->text), 120) !!}
                                    </span>
                                    <span class="news-card__date text _fz-xxxs _color-faint-strong">
                                        {{ localizedDate($obj->published_at) }}
                                    </span>
                                </span>
                            </a>
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
        <div class="_md:hide _mt-xs">
            <a href="{{ route('news') }}" class="link link--all-results link--theme-gray link--no-decoration link--mobile-bg-white _flex _justify-center _flex-grow _px-sm _md:px-none">
                <span class="link__text text _fz-sm">
                    @lang('cms-news::site.Все акции и новости')
                </span>
                <span class="link__icon">
                    @svg('common', 'arrow-right', [11, 11])
                </span>
            </a>
        </div>
    </div>
</div>
