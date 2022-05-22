<div class="section section--bg-base-strong">
    <div class="container">
        <div class="box box--features">
            <div class="_grid _grid--1 _xs:grid--2 _lg:grid--4 _spacer _spacer--sm _md:spacer--df">
                @foreach($result as $item)
                    <div class="_cell">
                        <div class="_flex _items-start _spacer _spacer--xs _sm:spacer--sm _justify-start">
                            <div class="icon icon--size-lg icon--theme-faint _box-content">
                                @svg('features', $item->icon)
                            </div>
                            <div>
                                <div class="text _fz-def _color-white _mb-xs">
                                    {{ $item->name }}
                                </div>
                                <div class="text _fz-xs _color-white-50">
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
