<?php

namespace WezomCms\News\Widgets;

use Illuminate\Support\Collection;
use WezomCms\Core\Foundation\Widgets\AbstractWidget;
use WezomCms\Core\Models\Translation;
use WezomCms\News\Models\News;
use WezomCms\News\Models\NewsTranslation;

class LatestNews extends AbstractWidget
{
    /**
     * A list of models that, when changed, will clear the cache of this widget.
     *
     * @var array
     */
    public static $models = [News::class, NewsTranslation::class, Translation::class];

    /**
     * @return array|null
     */
    public function execute(): ?array
    {
        /** @var Collection $result */
        $result = News::published()
            ->orderByDesc('published_at')
            ->latest('id')
            ->limit($this->parameter('limit', 5))
            ->get();

        if ($result->isEmpty()) {
            return null;
        }

        return compact('result');
    }
}
