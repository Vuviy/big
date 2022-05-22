<?php

namespace WezomCms\About\Widgets\Site;

use WezomCms\About\Models\AboutReview;
use WezomCms\Core\Foundation\Widgets\AbstractWidget;
use WezomCms\Core\Models\Translation;

class Reviews extends AbstractWidget
{
    /**
     * A list of models that, when changed, will clear the cache of this widget.
     *
     * @var array
     */
    public static $models = [AboutReview::class, Translation::class];

    /**
     * @return array|null
     */
    public function execute(): ?array
    {
        $result = AboutReview::published()
            ->latest()
            ->limit(20)
            ->get();

        return [
            'result' => $result
        ];
    }
}
