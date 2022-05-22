@php
    /**
     * @var $item object|array
     */
@endphp
@php
    $hidden = is_array($item) ? ($item['hidden'] ?? false) : ($item->hidden ?? false);
@endphp
<li>
    @if($hidden)
        @if(isset($item['id']) && !empty($items[$item['id']]))
            @foreach($items[$item['id']] as $subItem)
                @include('cms-sitemap::site.recursive-item', ['items' => $items, 'item' => $subItem])
            @endforeach
        @endif
    @else
        @if(isset($item['url']))
            <a href="{{ url($item['url']) }}">{{ $item['name'] }}</a>
        @elseif(!$hidden)
            <span>{{ $item['name'] }}</span>
        @endif
        @if(isset($item['id']) && !empty($items[$item['id']]))
            <ul>
                @foreach($items[$item['id']] as $subItem)
                    @include('cms-sitemap::site.recursive-item', ['items' => $items, 'item' => $subItem])
                @endforeach
            </ul>
        @endif
    @endif
</li>
