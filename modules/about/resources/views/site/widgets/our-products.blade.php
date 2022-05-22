@php
    /**
     * @var $settings array
     */
@endphp

<div class="about-products">
    <div class="about-products__grid">
        <div class="about-products__image">
            <div class="about-products__decor">
                <img src="{{ asset('images/about/banner-decor.svg') }}" alt="">
            </div>
            @if(isset($settings['image_block_description']) && $settings['image_block_description']->imageExists())
                <img src="{{ $settings['image_block_description']->getImageUrl() }}" alt="@lang('cms-about::site.About')">
            @endif
        </div>
        <div class="about-products__content">
            @if(!empty($settings['quote_block_description']))
                <div class="about-products__quote">
                    {{ $settings['quote_block_description'] }}
                </div>
            @endif

            @if(!empty($settings['description_block_description']))
                <div class="about-products__description _mt-lg">
                    {!! $settings['description_block_description'] !!}
                </div>
            @endif

            <div class="_grid">
                <div class="_cell _cell--12 _md:cell--9 _df:pr-xs">
                    <a class="button button--theme-yellow button--full-width _mt-lg _control-height-md _px-md _b-r-sm" href="{{ route('catalog') }}">@lang('cms-about::site.Перейти в каталог')</a>
                </div>
            </div>
        </div>
    </div>
</div>






