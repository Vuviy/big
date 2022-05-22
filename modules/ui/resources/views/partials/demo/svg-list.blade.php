@php
    /**
     * @var $path string
     */

    $icons = getSvgList($path)
@endphp
<div class="_grid _grid--4 _md:grid--6 _df:grid--9 _lg:grid--12 _spacer _spacer--sm">
    @foreach($icons as $icon)
        <div class="_cell svg-sprite" title="{{ $icon }}">
            <div class="svg-sprite__icon">
                @svg($path, $icon, 100, 'svg-sprite__svg')
            </div>
            <p class="svg-sprite__name">{{ $icon }}</p>
        </div>
    @endforeach
</div>
