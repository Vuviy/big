@php
    /**
     * @var $menu array|\WezomCms\Menu\Models\Menu[][]
     * @var $maxDepth int
     * @var $cabinetMenu \Lavary\Menu\Builder
     */
@endphp

@foreach($menu as $key => $item)
    <li class="mobile-menu__item list__item">
        <a href="{{ url($item->url) }}"
           class="mobile-menu__link link _no-underline"
        >
                <span class="link__text text _fz-xs _color-faint-strong">
                    {{ $item->name }}
                </span>
        </a>
    </li>
@endforeach
