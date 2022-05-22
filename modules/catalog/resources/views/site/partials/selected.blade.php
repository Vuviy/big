@php
    /**
     * @var $selected \Illuminate\Support\Collection
     * @var $baseUrl string
     * @var $queryParams array|null
     */
@endphp

<div class="_lg:hide _flex _justify-between _items-center">
    <button class="button" @click="toggleFilter($event)">
        <span class="button__icon button__icon--left">
            @svg('common', 'arrow-left', 11, '_mr-sm')
        </span>
        <span class="button__text">
            @lang('cms-catalog::site.Фильтры')
        </span>
    </button>
</div>

@if($selected->isNotEmpty())
    <div class="accordion accordion--filter-group">
        <div class="accordion__header _cursor-default">
            <div class="text _fz-def _fw-bold _color-black">@lang('cms-catalog::site.Выбрано')</div>

            @if($selected->count())
                <a href="{{ $baseUrl }}" rel="nofollow" class="link link--theme-gray _fz-xxxs _no-underline" data-reset>
                    @lang('cms-catalog::site.Сбросить все')
                </a>
            @endif
        </div>
        <div class="accordion__body">
            <div class="_grid _grid--1 _spacer _spacer--xs _mb-none">
                @foreach($selected as $item)
                    <div class="_cell">
                        <a
                            href="{{ $item['removeUrl'] }}"
                            class="button button--theme-gray _b-r-lg _control-height-xs _control-padding-sm _control-space-xs"
                        >
                                <span class="button__text _fz-xs _color-black">
                                    {{ $item['name'] }}
                                </span>
                            <span class="button__icon button__icon--right">
                                    @svg('common', 'cross', 8)
                                </span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
