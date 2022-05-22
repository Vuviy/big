@php
    /**
     * @var $menu array|\WezomCms\Menu\Models\Menu[][]
     * @var $maxDepth int
     */
@endphp
@if(isset($menu))
    <nav class="top-menu">
        <ul class="top-menu__list list">
            @foreach($menu as $key => $item)
                <li class="top-menu__item">
                    <a href="{{ url($item->url) }}" class="top-menu__link _fz-xs">{{ $item->name }}</a>
                </li>
            @endforeach
        </ul>
    </nav>
@endif

