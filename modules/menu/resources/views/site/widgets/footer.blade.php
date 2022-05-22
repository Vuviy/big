@php
    /**
     * @var $menu array|\WezomCms\Menu\Models\Menu[][]
     * @var $maxDepth int
     */
@endphp
@if(isset($menu))
    <div class="footer-menu">
        @foreach($menu as $key => $item)
                <div class="footer-menu__group">
                    <div class="footer-menu__title" data-tabs-ns="footer-menu" data-tabs-button="{{ $loop->index }}">
                        <span>{{ $item->name }}</span>
                    </div>
                    @if($item->children && count($item->children))
                        <div class="footer-menu__list" data-tabs-ns="footer-menu" data-tabs-block="{{ $loop->index }}">
                            @foreach($item->children as $child)
                                <a href="{{ url($child->url) }}" class="footer-menu__item">{{ $child->name }}</a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
    </div>
@endif
