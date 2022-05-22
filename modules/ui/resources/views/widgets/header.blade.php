<header class="header"
        x-data="app.alpine.header()"
        x-init="mmenuInit(); $watch('isMobileNavOpen', () => closeMmenu())"
        x-ref="header"
>
    <div class="header__top" x-ref="headerTop">
        <div class="container {{ $containerModification ? 'container--' . $containerModification : null }}">
            <div class="header__top-inner">
                <div class="logo _mr-md">
                    @if(Request::is('/'))
                        @svg('logo', 'logo', [211, 39], 'logo__image')
                    @else
                        <a href="{{ route('home') }}" class="logo__link">
                            @svg('logo', 'logo', [211, 39], 'logo__image')
                        </a>
                    @endif
                </div>
                <div class="_lg:show">
                    @widget('menu:header')
                </div>
                <div class="_ml-auto _lg:show">
                    @widget('cabinet-button')
                </div>
                <div class="_flex _ml-auto _mr-sm _lg:hide _spacer _spacer--xs">
                    <div class="header__control-button"
                        :hidden="isSearchBarOpen"
                    >
                        <button class="button" type="button"
                                @click="openSearch($event)"
                        >
                        <span class="icon icon--size-md icon--theme-default">
                            @svg('common', 'loupe', [18, 18])
                        </span>
                        </button>
                    </div>
                    <livewire:favorites.header-button />
                    <livewire:orders.header-cart-button/>
                </div>
                <div class="menu-trigger _lg:hide">
                    <button class="menu-trigger__button button"
                            type="button"
                            @click="toggleMobileNav($event)"
                    >
                        <span class="menu-trigger__line"></span>
                        <span class="menu-trigger__line"></span>
                        <span class="menu-trigger__line"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="header__bottom"
    >
        <div class="container {{ $containerModification ? 'container--' . $containerModification : null }}">
            <div class="header__bottom-inner header__bottom-inner--menu"
                 :hidden="isSearchBarOpen"
            >
                <div class="header__control-button _lg:show"
                     :hidden="isDesktopNavOpen"
                >
                    <button class="button" type="button"
                            @click="openSearch($event)"
                    >
                        <span class="icon icon--size-md icon--theme-default">
                            @svg('common', 'loupe', [18, 18])
                        </span>
                    </button>
                </div>
                <div class="header__control-button _lg:show"
                     hidden
                     :hidden="!isDesktopNavOpen"
                >
                    <button class="button"
                            @click="toggleDesktopNav($event)"
                    >
                        <span class="icon icon--size-md icon--theme-default">
                            @svg('common', 'cross', [18, 18])
                        </span>
                    </button>
                </div>
                <div class="header__bottom-menu _lg:show">
                    @widget('catalog:header-menu')
                    <div class="_flex">
                        <livewire:favorites.header-button />
                        <div class="separator separator--vertical separator--offset-xs separator--theme-gray"></div>
                        <livewire:orders.header-cart-button/>
                    </div>
                </div>
            </div>
            <div class="header__bottom-inner header__bottom-inner--search"
                 hidden
                 :hidden="!isSearchBarOpen"
                 @click.away="isSearchBarOpen = !isSearchBarOpen"
            >
                <div class="container container--md">
                    <div class="header__search _lg:pr-df">
                        <livewire:catalog.live-search />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header__dropdown-menu"
         x-ref="dropdownMenu"
         :class="{'is-active': isDesktopNavOpen}"
    >
        @widget('catalog:menu-tree')
    </div>
    @include('cms-ui::widgets.mobile-nav')
</header>
