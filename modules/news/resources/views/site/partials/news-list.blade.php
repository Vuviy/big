@php
    /**
     * @var $result \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|\WezomCms\News\Models\News[]
     */
@endphp

<div class="_grid _grid--1 _xs:grid--2 _df:grid--3 _lg:grid--4 _spacer _spacer--md">
    @foreach($result as $item)
        <div class="_cell">
            <a href="{{ $item->getFrontUrl() }}" class="news-card">
            <span class="news-card__img">
                <img class="lazy" src="{{ url('/images/core/no-image.png') }}"
                     data-src="{{ $item->getImageUrl('medium') }}" alt="{{ $item->name }}">
            </span>
                <span class="news-card__body">
                <span class="news-card__title text _fz-xs _color-black">
                    {{ $item->name }}
                </span>
                <span class="news-card__text text _fz-xxxs _color-faint-strong">
                    {!! str_limit(strip_tags($item->text), 120) !!}
                </span>
                <span class="news-card__date text _fz-xxxs _color-faint-strong">
                    {{ localizedDate($item->published_at) }}
                </span>
            </span>
            </a>
        </div>
    @endforeach
</div>
