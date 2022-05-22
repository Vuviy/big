@php
    /**
     * @var $title null|string
     * @var \Illuminate\Database\Eloquent\Collection|\WezomCms\Catalog\Models\Product
     */
    $sliderType = $sliderType ?? 'product-carousel-five-slides';
    $showRegisterHint = $showRegisterHint ?? false;
    $whiteTheme = $whiteTheme ?? true;
@endphp
<div class="section section--off-t-md {{ $modification ?? null ? 'section--' . $modification : null }}">
    <div class="container container--slider-transformed _overflow-hidden">
        <div class="_grid _justify-between _items-center _spacer _spacer--sm _mb-sm _lg:mb-lg">
            <div class="_cell _cell--auto">
                @if(!empty($title))
                    <div class="text _fz-xl _fw-bold">
                        {{ $title }}
                    </div>
                @endif
            </div>
            @if(!empty($catalogLinkName))
                <div class="_cell _cell--auto _md:show">
                    <a href="{{ $catalogLinkUrl }}" class="link link--all-results link--theme-gray link--no-decoration">
                        <span class="link__text text _fz-sm">
                            {{ $catalogLinkName }}
                        </span>
                        <span class="link__icon">
                            @svg('common', 'arrow-right', [11, 11])
                        </span>
                    </a>
                </div>
            @endif
        </div>
        <div class="product-slider js-dmi" data-slider="{{ $sliderType }}">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @foreach($result as $item)
                        <div class="swiper-slide">
                            @include('cms-catalog::site.partials.cards.product-card')
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
        </div>
        @if(!empty($catalogLinkName))
            <div class="_flex _flex-grow _md:hide _mt-sm _mb-md">
                <a href="{{ $catalogLinkUrl }}" class="link link--all-results link--theme-gray link--no-decoration @if($whiteTheme) link--mobile-bg-faint-weak @else link--mobile-bg-white @endif _flex _justify-center _flex-grow _px-sm _md:px-none">
                    <span class="link__text text _fz-sm">
                        {{ $catalogLinkName }}
                    </span>
                    <span class="link__icon">
                        @svg('common', 'arrow-right', [11, 11])
                    </span>
                </a>
            </div>
        @endif
        @auth
            @else
                @if($showRegisterHint)
                    <div class="box box--register _md:hide _mb-md">
                        <div class="text _fz-def _color-black _text-center _mb-sm">
                            @lang('cms-catalog::site.Войдите, чтобы использовать преимущества зарегистрированного пользователя')
                        </div>
                        <div class="_flex _flex-grow">
                            <button type="button"
                                    class="button button--theme-black _b-r-sm _flex _flex-grow _text-center"
                                    x-data="app.alpine.openModal('users.auth-modal')"
                                    @click="open"
                                    @mouseenter="open"
                            >
                        <span class="link__text text _fz-lg _color-white">
                            @lang('cms-catalog::site.Войти или зарегистрироваться')
                        </span>
                            </button>
                        </div>
                    </div>
                @endif
        @endauth
    </div>
</div>
