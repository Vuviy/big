<?php

namespace WezomCms\About\Widgets\Site;

use WezomCms\About\Models\AboutEvent;
use WezomCms\About\Models\AboutEventTranslation;
use WezomCms\Core\Foundation\Widgets\AbstractWidget;
use WezomCms\Core\Models\Translation;

class EventHistory extends AbstractWidget
{
    /**
     * A list of models that, when changed, will clear the cache of this widget.
     *
     * @var array
     */
    public static $models = [AboutEvent::class, AboutEventTranslation::class, Translation::class];

    /**
     * @return array|null
     */
    public function execute(): ?array
    {
        $result = AboutEvent::published()
            ->latest('happened_at')
            ->get()
            ->groupBy(function ($item) {
                return $item->happened_at->format('Y');
            })->sortKeys();

        if ($result->isEmpty()) {
            return null;
        }

        return [
            'result' => $result
        ];
    }
}
