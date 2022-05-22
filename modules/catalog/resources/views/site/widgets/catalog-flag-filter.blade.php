<div class="_grid _spacer _spacer--xs">
    @foreach($labelResult as $item)
        <div class="_cell">
            <a
                href="{{ $item['url'] }}"
                class="button button--theme-outline-gray _b-r-lg _control-height-xs _control-padding-sm {{ $item['selected'] ? 'is-active' : '' }}"
{{--                @if($item['selected']) disabled @endif--}}
            >
                <span class="button__text">{{ $item['name'] }}</span>
            </a>
        </div>
    @endforeach
</div>
