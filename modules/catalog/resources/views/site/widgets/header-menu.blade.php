@php
    /**
     * @var $menu \Illuminate\Database\Eloquent\Collection|\WezomCms\Menu\Models\Menu[]
     */
@endphp
<div class="main-menu">
    <div class="main-menu__list list">
        <div class="main-menu__item">
            <span class="main-menu__link"
               :class="{'is-active': isDesktopNavOpen}"
               @click="toggleDesktopNav($event)"
            >
                <span class="main-menu__link-icon">
                    @svg('common', 'grid', [12, 13])
                </span>
                <span>@lang('cms-catalog::site.Каталог товаров')</span>
            </span>
        </div>
        <div :hidden="isDesktopNavOpen"
             style="display: flex"
        >
            @foreach($menu as $item)
                @if($loop->last)
                    <div class="separator separator--vertical separator--theme-gray"></div>
                @endif
                <div>
                    @if($loop->last)
                        <span class="_flex _items-center">
                        <a href="{{ url($item->url) }}" class="main-menu__link">
                            <span>{{ $item->name }}</span>
                        </a>
                        <span class="icon icon--size-sm">
                            @svg('common', 'lightning', [12, 16])
                        </span>
                    </span>
                    @else
                        <a href="{{ url($item->url) }}" class="main-menu__link">
                            <span>{{ $item->name }}</span>
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>
