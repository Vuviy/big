<?php

namespace WezomCms\Favorites\Widgets;

use WezomCms\Catalog\Models\Product;
use WezomCms\Core\Foundation\Widgets\AbstractWidget;

class ProductListButton extends AbstractWidget
{
    /**
     * @return array|null
     */
    public function execute()
    {
        $product = array_get($this->data, 'product');

        return $product instanceof Product ? compact('product') : null;
    }
}
