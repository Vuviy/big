<?php

namespace WezomCms\News\Widgets;

use Illuminate\Support\Collection;
use WezomCms\Core\Foundation\Widgets\AbstractWidget;
use WezomCms\News\Models\NewsTag;

class Tags extends AbstractWidget
{
    /**
     * The number of minutes before cache expires.
     * False means no caching at all.
     * If debug mode is on - the widget will not be cached.
     *
     * @var int|float|bool
     */
    public $cacheTime = 10; // 10 minutes

    /**
     * @return array|null
     */
    public function execute(): ?array
    {
        if (!config('cms.news.news.use_tags')) {
            return null;
        }

        $currentTag = $this->parameter('currentTag');

        /** @var Collection $result */
        $result = NewsTag::published()
            ->withCount('news')
            ->whereHas('news', published_scope())
            ->orderByDesc('news_count')
            ->latest('id')
            ->limit($this->parameter('limit', 15))
            ->get();

        if ($result->isEmpty()) {
            return null;
        }

        return compact('result', 'currentTag');
    }
}
