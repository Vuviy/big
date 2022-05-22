@php
    /**
     * @var $paginator \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Contracts\Pagination\Paginator
     * @var $elements array
     */
@endphp
@if ($paginator->hasPages())
    <div class="pagination" role="navigation">
        {{-- Previous Page Link --}}
        @if (!$paginator->onFirstPage())
            <a
                href="{{ $paginator->previousPageUrl() }}"
                class="pagination__btn pagination__btn--arrow"
                rel="prev"
            >
                <span class="arrow-button arrow-button--theme-default">
                    @svg('common', 'arrow-left', 11)
                </span>
            </a>
        @else
            <span
                class="pagination__btn pagination__btn--arrow disabled"
            >
                <span class="arrow-button arrow-button--theme-default">
                    @svg('common', 'arrow-left', 11)
                </span>
            </span>
        @endif

        @php
            $around = $paginator->currentPage() <= 2 ? 2 : 1;
                $aroundStart = $paginator->currentPage() == $paginator->lastPage() ? 3
                    : ($paginator->currentPage() + 1 == $paginator->lastPage() ? 2 : 1);

            $start = $paginator->currentPage() - $aroundStart;
            $end = $paginator->currentPage() + $around;
            if($start < 1) {
                $start = 1; // reset start to 1
                $end += 1;
            }
            if($end >= $paginator->lastPage() ) $end = $paginator->lastPage(); // reset end to last page
        @endphp

        @if($start > 1)
            <a href="{{ $paginator->url(1) }}" class="pagination__btn">1</a>
            @if($paginator->currentPage() >= 4)
                {{-- "Three Dots" Separator --}}
                <span class="pagination__btn _events-none">...</span>
            @endif
        @endif

        <span class="pagination__separator"></span>
        @for ($i = $start; $i <= $end; $i++)
            @if ($i == $paginator->currentPage())
                <span class="pagination__btn disabled">{{ $i }}</span>
            @else
                <a href="{{ $paginator->url($i) }}" class="pagination__btn">{{ $i }}</a>
            @endif
            <span class="pagination__separator"></span>
        @endfor

{{--        @if($end < $paginator->lastPage())--}}
{{--            @if($paginator->currentPage() + 2 != $paginator->lastPage())--}}
{{--                --}}{{-- "Three Dots" Separator --}}
{{--                <span class="pagination__btn _events-none">...</span>--}}
{{--            @endif--}}
{{--            <a href="{{ $paginator->url($paginator->lastPage()) }}" class="pagination__btn">{{ $paginator->lastPage() }}</a>--}}
{{--        @endif--}}

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a
                href="{{ $paginator->nextPageUrl() }}"
                class="pagination__btn pagination__btn--arrow"
                rel="next"
            >
                <span class="arrow-button arrow-button--theme-default">
                    @svg('common', 'arrow-right', 11)
                </span>
            </a>
        @else
            <span
                class="pagination__btn pagination__btn--arrow disabled"
            >
                <span class="arrow-button arrow-button--theme-default">
                    @svg('common', 'arrow-right', 11)
                </span>
            </span>
        @endif
    </div>
@endif
