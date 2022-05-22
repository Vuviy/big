@php
    /**
     * @var $items Illuminate\Support\Collection
     */
@endphp
<div class="breadcrumbs">
    <div class="container {{ isset($containerModification) ? 'container--' . $containerModification : null }}">
        <div class="_flex _items-center _flex-wrap">
            @foreach($items as $key => $item)
                <a class="breadcrumbs__link" @if(!$loop->last)href="{{ url($item['link']) }}"@endif>{{ $item['name'] }}</a>
                @if(!$loop->last)
                    <div class="breadcrumbs__separator"></div>
                @endif
            @endforeach
        </div>
    </div>
</div>
