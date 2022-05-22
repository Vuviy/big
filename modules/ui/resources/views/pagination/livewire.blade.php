@if ($paginator->hasPages())
    <div class="paginate" role="navigation">
        {{-- Previous Page Link --}}
        @if($paginator->onFirstPage())
            <span class="paginate__btn paginate__btn_prev paginate__btn_disabled">
                <span class="paginate__btn-icon">
                    @svg('common', 'curve-left-20', 20)
                </span>
                <span class="paginate__btn-text">@lang('cms-ui::site.Предыдущая')</span>
            </span>
        @else
            <button type="button" class="paginate__btn paginate__btn_prev" rel="prev" wire:click="previousPage">
                <span class="paginate__btn-icon">
                    @svg('common', 'curve-left-20', 20)
                </span>
                <span class="paginate__btn-text">@lang('cms-ui::site.Предыдущая')</span>
            </button>
        @endif

        {{-- Pagination Elements --}}
        <ul class="paginate__list">
            @foreach($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if(is_string($element))
                    <li class="paginate__li">
                        <span class="paginate__link paginate__link_ellipsis">...</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if(is_array($element))
                    @foreach($element as $page => $url)
                        <li class="paginate__li" wire:key="paginator-page-{{ $page }}">
                            @if($page == $paginator->currentPage())
                                <span class="paginate__link paginate__link_active">{{ $page }}</span>
                            @else
                                <span class="paginate__link" wire:click="gotoPage({{ $page }})">{{ $page }}</span>
                            @endif
                        </li>
                    @endforeach
                @endif
            @endforeach
        </ul>

        {{-- Next Page Link --}}
        @if($paginator->hasMorePages())
            <button type="button" class="paginate__btn paginate__btn_next" rel="next" wire:click="nextPage">
                <span class="paginate__btn-text">@lang('cms-ui::site.Следующая')</span>
                <span class="paginate__btn-icon">
                    @svg('common', 'curve-right-20', 20)
                </span>
            </button>
        @else
            <span class="paginate__btn paginate__btn_next paginate__btn_disabled">
                <span class="paginate__btn-text">@lang('cms-ui::site.Следующая')</span>
                <span class="paginate__btn-icon">
                    @svg('common', 'curve-right-20', 20)
                </span>
            </span>
        @endif
    </div>
@endif
