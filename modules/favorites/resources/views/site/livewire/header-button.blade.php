@php
    /**
     * @var $count int
     */
@endphp
<div>
    <a href="{{ route('favorites') }}"
       class="header-button"
       title="@lang('cms-favorites::site.Перейти к избранным')"
    >
        <span class="header-button__icon icon">
            @svg('common', 'heart-stroke', 20)
        </span>
        @if($count)
            <span class="header-button__counter">
                <span class="text _fz-xs _color-black">{{ $count }}</span>
            </span>
        @endif
    </a>
</div>
