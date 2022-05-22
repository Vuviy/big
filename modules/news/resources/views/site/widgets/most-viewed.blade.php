@php
    /**
     * @var $result \Illuminate\Database\Eloquent\Collection|\WezomCms\News\Models\News[]
     */
@endphp
@lang('cms-news::site.Топ :count', ['count' => $result->count()]) {{ trans_choice('cms-news::site.новость|новости|новостей', $result->count()) }}
<div>
    @foreach($result as $item)
        <div>
            <a href="{{ $item->getFrontUrl() }}">
                <img class="lazy" src="{{ url('/images/core/no-image.png') }}"
                     data-src="{{ $item->getImageUrl() }}" alt="{{ $item->name }}">
            </a>
            <a href="{{ $item->getFrontUrl() }}">{{ $item->name }}</a>
            {{ $item->published_at->format('d.m.Y') }}
        </div>
    @endforeach
</div>
