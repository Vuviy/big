<nav
    hidden
    x-ref="menuList"
    data-menu-title="@lang('cms-catalog::site.Каталог товаров')"
>
    @if($categories->isNotEmpty())
        <ul>
            @foreach($categories as $rootItem)
                <li>
                    <a href="{{ $rootItem->getFrontUrl() }}">
                        {{ $rootItem->name }}
                    </a>
                    @if($rootItem->relationLoaded('children') && $rootItem->children->isNotEmpty())
                        <ul>
                            @foreach($rootItem->children as $childLevel1)
                                <li>
                                    <a href="{{ $childLevel1->getFrontUrl() }}">
                                        {{ $childLevel1->name }}
                                    </a>
                                    @if($childLevel1->relationLoaded('children') && $childLevel1->children->isNotEmpty())
                                        <ul>
                                            @foreach($childLevel1->children as $childLevel2)
                                                <li>
                                                    <a href="{{ $childLevel2->getFrontUrl() }}">
                                                        {{ $childLevel2->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    @endif
</nav>
<div class="_grid _grid--1 _sm:grid--2 _md:grid--3 _spacer _spacer--xs">
    <div class="_cell _flex _flex-grow">
        <button type="button"
                class="button button--theme-yellow _b-r-sm _control-height-md _control-padding-xs _control-space-xs _flex-grow _justify-start"
                @click="openMmenu($event)"
        >
                        <span class="button__icon button__icon--left">
                            @svg('common', 'grid', [12, 13])
                        </span>
            <span class="button__text">
                            @lang('cms-catalog::site.Каталог товаров')
                        </span>
        </button>
    </div>
    @if($menuLast)
        <div class="_cell _flex _flex-grow">
            <a href="{{ $menuLast->getFrontUrl() }}"
               class="button button--theme-gray-mobile _b-r-sm _control-height-md _control-padding-xs _control-space-xs _flex-grow _justify-start"
            >
                <span class="button__icon button__icon--left">
                    @svg('common', 'lightning', [12, 16])
                </span>
                <span class="button__text">{{ $menuLast->name }}</span>
            </a>
        </div>
    @endif
</div>
