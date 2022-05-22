@php
/**
 * @var array $links
 * @var array $current
 */
@endphp
<div class="js-language-switch">
    <button>{{ mb_strtoupper($current['locale']) }}</button>
    <div>
        @if(count($links) > 1)
            <ul>
                @foreach($links as $locale => $item)
                    @continue($item['active'])
                    <li>
                        <a href="{{ $item['url'] }}">{{ mb_strtoupper(str_replace('uk', 'ua', $locale)) }}</a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
