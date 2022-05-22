<?php

namespace WezomCms\Branches\Widgets;

use WezomCms\Branches\Models\Branch;
use WezomCms\Branches\Models\BranchTranslation;
use WezomCms\Core\Foundation\Widgets\AbstractWidget;
use WezomCms\Core\Models\Translation;

class Branches extends AbstractWidget
{
    /**
     * A list of models that, when changed, will clear the cache of this widget.
     *
     * @var array
     */
    public static $models = [Branch::class, BranchTranslation::class, Translation::class];

    /**
     * @return array|null
     */
    public function execute(): ?array
    {
        $branches = Branch::published()
            ->sorting()
            ->get();

        if ($branches->isEmpty()) {
            return null;
        }

        return compact('branches');
    }
}
