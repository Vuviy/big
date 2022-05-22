@php
    /**
     * @var $socials array
     */
@endphp
<div class="footer-menu__group">
    @foreach($socials as $name => $link)
        <a class="footer-menu__item _flex _items-center _justify-center _md:justify-start" href="{{ url($link) }}">
            @svg('socials', \Illuminate\Support\Str::lower($name)).'-stroke', 20, '_mr-xs') Мы в соцсетях
        </a>
    @endforeach
</div>
