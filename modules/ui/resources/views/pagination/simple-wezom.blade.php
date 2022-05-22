@php
    /**
     * @var $paginator \Illuminate\Pagination\Paginator
     */
@endphp
@if ($paginator->hasPages())
    <ul class="pagination" role="navigation">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled" aria-disabled="true"><span>@lang('cms-ui::site.Назад')</span></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">@lang('cms-ui::site.Назад')</a></li>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">@lang('cms-ui::site.Вперед')</a></li>
        @else
            <li class="disabled" aria-disabled="true"><span>@lang('cms-ui::site.Вперед')</span></li>
        @endif
    </ul>
@endif
