@php
    /**
     * @var $menu \Lavary\Menu\Builder
     */
@endphp
@foreach($menu->roots() as $item)
    <div>
        @if($item->isActive)
            <span class="is-active">{{ $item->title }}</span>
        @elseif($item->url())
            <a href="{{ $item->url() }}"
               class="{{ $item->class }}" {!! $item->el_attributes !!}>{{ $item->title }}</a>
        @endif
    </div>
@endforeach
