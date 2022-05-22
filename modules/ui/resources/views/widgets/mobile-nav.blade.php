<div class="mobile-nav _lg:hide"
     :class="{'is-active': isMobileNavOpen}"
>
    <div class="mobile-nav__header">
        @widget('cabinet-button')
        <div class="header__control-button"
        >
            <button class="button"
                    @click="toggleMobileNav($event)"
            >
                    <span class="icon icon--size-md icon--theme-default">
                        @svg('common', 'cross', [18, 18])
                    </span>
            </button>
        </div>
    </div>
    <div class="mobile-nav__body">
        @widget('catalog:mobile-menu')
        <div class="mobile-nav__quick-menu">
            <ul class="mobile-menu list">
                @widget('cabinet-menu', [], 'cms-users::site.widgets.mobile-cabinet-menu')
                @widget('menu:mobile')
            </ul>
        </div>
    </div>
    <div class="mobile-nav__footer">
        @php($freePhone = settings('contacts.phones.free_phone'))
        @if(!empty($freePhone))
            <div class="_grid _spacer _spacer--md">
                <div class="_cell _cell--auto">
                    <a href="tel:{{ $freePhone }}"
                       class="link link--theme-black link--no-decoration"
                    >
                        <span class="link__text _fz-def _fw-bold">{{ $freePhone }}</span>
                    </a>
                </div>
                <div class="_cell _cell--auto">
                    @widget('contacts:phone-social-links')
                </div>
            </div>
        @endif
    </div>
</div>
