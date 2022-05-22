<div class="socials-widget"
     x-data="{ isActive : false }"
     :class="{'is-active' : isActive }"
>
    <div class="socials-widget__trigger" @click="isActive = !isActive"></div>
    <div class="socials-widget__inner">
        <div class="socials-widget__sprite">
            @svg('common', 'messenger-icon-1', [], 'socials-widget__sprite-svg')
            @svg('common', 'messenger-icon-2', [], 'socials-widget__sprite-svg')
            @svg('common', 'messenger-icon-3', [], 'socials-widget__sprite-svg')
            @svg('common', 'messenger-icon-4', [], 'socials-widget__sprite-svg')
            @svg('common', 'messenger-icon-5', [], 'socials-widget__sprite-svg')
            @svg('common', 'messenger-icon-6', [], 'socials-widget__sprite-svg')
            @svg('common', 'messenger-icon-7', [], 'socials-widget__sprite-svg')
        </div>
        @svg('common', 'cross', [30, 30], 'socials-widget__close')
        @svg('common', 'chat', [30, 30], 'socials-widget__placeholder')
    </div>
    <div class="socials-widget__dropdown">
        @foreach($socials as $key => $social)
            <a href="{{ $social }}"
               class="socials-widget__item socials-widget__item--{{ $key }}"
               target="_blank"
            >
                <span class="socials-widget__item-icon">
                    @svg('common', 'widget-' . $key, [44, 44])
                </span>
                <span class="socials-widget__item-text">
                    {{ ucfirst($key) }}
                </span>
            </a>
        @endforeach
        <div class="socials-widget__item socials-widget__item--callback">
            <button type="button"
                    x-data="app.alpine.openModal('callbacks.form')"
                    x-on:click="open"
                    x-on:mouseenter="open"
                    class="_flex _items-center _flex-grow"
            >
                <span class="socials-widget__item-icon">
                    @svg('common', 'widget-phone', [44, 44])
                </span>
                <span class="socials-widget__item-text">
                    @lang('cms-callbacks::site.Обратный звонок')
                </span>
            </button>
        </div>
    </div>
</div>
