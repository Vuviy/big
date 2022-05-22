<header class="header"
>
    <div class="header__top">
        <div class="container {{ $containerModification ? 'container--' . $containerModification : null }}">
            <div class="_flex _items-center _justify-between">
                <div class="logo">
                    @if(Request::is('/'))
                        @svg('logo', 'logo', [211, 39], 'logo__image')
                    @else
                        <a href="{{ route('home') }}" class="logo__link">
                            @svg('logo', 'logo', [211, 39], 'logo__image')
                        </a>
                    @endif
                </div>
                <div class="_flex _items-center">
                    <div class="text _fz-xs _color-white _mr-xs _md:show">@lang('cms-checkout::site.Нужна помощь?')</div>
                    <div class="_flex _items-center"
                         x-data="app.alpine.openModal('callbacks.form')"
                         x-on:click="open"
                         x-on:mouseenter="open"
                    >
                        <button type="button" class="text link link--no-decoration link--theme-white">
                            <span class="link__text _fz-xs _mr-xs">
{{--                                todo прокинуть номер --}}
                                0 800 12 23 34
                            </span>
                            <span class="link__text">
                                @svg('common', 'arrow-down', 10)
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
