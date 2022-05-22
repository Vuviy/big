@php
    /**
     * @var $result \Illuminate\Database\Eloquent\Collection|\WezomCms\News\Models\NewsTag[]
     * @var $currentTag null|string
     */
@endphp
@lang('cms-news::site.Основные теги')
<div class="js-import" data-tags="8">
    @foreach($result as $item)
        @if($item->slug === $currentTag)
            <strong>{{ $item->name }}</strong>
        @else
            <a href="{{ $item->getFrontUrl() }}">{{ $item->name }}</a>
        @endif
    @endforeach
    @if($result->count() > 8)
        <span data-tags-more title="@lang('cms-news::site.Показать все')">...</span>
    @endif
</div>
