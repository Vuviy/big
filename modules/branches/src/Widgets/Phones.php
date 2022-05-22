<?php

namespace WezomCms\Branches\Widgets;

use WezomCms\Branches\Models\Branch;
use WezomCms\Core\Foundation\Widgets\AbstractWidget;
use WezomCms\Core\Models\Translation;

class Phones extends AbstractWidget
{
    /**
     * A list of models that, when changed, will clear the cache of this widget.
     *
     * @var array
     */
    public static $models = [Branch::class, Translation::class];

    /**
     * View name.
     *
     * @var string|null
     */
    protected $view = 'cms-branches::site.widgets.phones-header';

    /**
     * @return array|null

     */
    public function execute(): ?array
    {
        $branches = Branch::published()
            ->sorting()
            ->get()
            ->filter(function (Branch $branch) {
                return count($branch->phones);
            });

        if ($branches->isEmpty()) {
            return null;
        }

        return compact('branches');
    }
}
