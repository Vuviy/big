<?php

namespace WezomCms\Catalog\Widgets\Site;

use Illuminate\Support\Collection;
use WezomCms\Core\Foundation\Widgets\AbstractWidget;

class CatalogFlagFilter extends AbstractWidget
{
    /**
     * View name.
     *
     * @var string
     */
    protected $view = 'cms-catalog::site.widgets.catalog-flag-filter';

    /**
     * @return array|null
     */
    public function execute(): ?array
    {
        $searchForm = array_get($this->data, 'searchForm');

        if (empty($searchForm) || !($searchForm instanceof Collection)) {
            return null;
        }

        $labelResult = $searchForm->firstWhere('name', 'flag');

        if (empty($labelResult['options'])) {
            return null;
        }

        $labelResult = $labelResult['options'];

        return compact('labelResult');
    }
}
