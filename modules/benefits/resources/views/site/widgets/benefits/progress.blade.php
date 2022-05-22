<div class="section section--bg-faint-weak section--off-t-lg section--off-b-lg">
    <div class="container">
        <div class="_grid _spacer _spacer--sm">
            <div class="_cell _cell--12 _lg:cell--3 _mb-df _lg:mb-none">
                <div class="logo logo--theme-black _mb-md">
                    @svg('logo', 'logo', [211, 48], 'logo__image')
                </div>
                <div class="text _fz-xl _fw-bold _color-black _mb-md">
                    @lang('cms-benefits::site.Наши 8 лет достижений, обозначенные цифрами')
                </div>
                <a href="{{route('about')}}" class="link link--all-results link--theme-gray link--no-decoration">
                    <span class="link__text text _fz-sm">
                        @lang('cms-benefits::site.Подробнее о компании')
                    </span>
                    <span class="link__icon">
                        @svg('common', 'arrow-right', [11, 11])
                    </span>
                </a>
            </div>
            <div class="_cell _cell--12 _lg:cell--9">
                <div class="_grid _grid--1 _xs:grid--2 _md:grid--3 _lg:spacer--xl _spacer _spacer--md _df:spacer--xl">
                    @foreach($result as $item)
                        <div class="_cell">
                            <div class="_flex _items-start _spacer _spacer--xs _sm:spacer--sm _justify-start">
                                <div class="icon icon--size-xl icon--theme-black _box-content">
                                    @svg('features', $item->icon)
                                </div>
                                <div>
                                    <div class="text _fz-def _color-black _mb-xs">
                                        {{ $item->name }}
                                    </div>
                                    <div class="text _fz-xs _color-black-50">
                                        {{ $item->description }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
