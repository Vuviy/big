@php
    $instagram = array_get(settings('contacts.social',[]), 'instagram');
@endphp
<footer class="footer">
    <div class="container container--lg">
        <div class="footer__grid">
            <div class="footer__socials _flex _flex-column">
                <livewire:newsletter.subscribe/>
                <div class="footer__contacts">
                    <div class="_md:mb-md">
                        @widget('contacts:footer')
                    </div>
                </div>
            </div>

            <div class="footer__menu _flex _flex-column _text-center _md:text-left">
                @widget('menu:footer')

                <div class="footer-menu footer-menu--no-gap _mt-df">
                    <div class="footer-menu__group">
                        <a class="footer-menu__item" href="{{ route('catalog') }}">@lang('cms-ui::site.Перейти в каталог')</a>
                    </div>
                    @if($instagram)
                    <div class="footer-menu__group _self-center">
                        <a class="footer-menu__item _flex _items-center _justify-center _md:justify-start" href="{{$instagram}}">
                            @svg('socials', 'instagram-stroke', 20, '_mr-xs') <span class="_fz-xxxs">@lang('cms-ui::site.Мы в соцсетях')</span>
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="copyright copyright--desktop _text-center _py-md">
            © {{date('Y')}} — @lang('cms-ui::site.Надёжный интернет супермаркет «Bigpayda.kz»')
        </div>
    </div>
</footer>
