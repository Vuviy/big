<?php

namespace WezomCms\Catalog\Widgets\Site;

use WezomCms\Catalog\Models\Product;
use WezomCms\Core\Foundation\Widgets\AbstractWidget;

class ProductLabels extends AbstractWidget
{
    /**
     * View name.
     *
     * @var string
     */
    protected $view = 'cms-catalog::site.widgets.product-labels';

    /**
     * @return array|null
     */
    public function execute(): ?array
    {
        $product = array_get($this->data, 'product');


        if (!isset($product) || !($product instanceof Product)) {
            return null;
        }

        return compact('product');
    }
}
