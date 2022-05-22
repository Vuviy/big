<?php

namespace WezomCms\Catalog\Widgets\Site;

use WezomCms\Catalog\Models\Category;
use WezomCms\Catalog\Models\CategoryTranslation;
use WezomCms\Catalog\Models\Product;
use WezomCms\Catalog\Models\ProductImage;
use WezomCms\Catalog\Models\ProductTranslation;
use WezomCms\Core\Foundation\Widgets\AbstractWidget;

class SameProducts extends AbstractWidget
{
    /**
     * View name.
     *
     * @var string
     */
    protected $view = 'cms-catalog::site.widgets.products-carousel';

    /**
     * @return array|null
     */
    public function execute(): ?array
    {
        /** @var Product $product */
        $productId = $this->parameter('productId');
        $productCategoryId = $this->parameter('productCategoryId');

        if (!$productId || !$productCategoryId) {
            return null;
        }

        $products = Product::where('category_id', $productCategoryId)
            ->whereKeyNot($productId)
            ->published()
            ->available()
            ->fullSelection()
            ->inRandomOrder()
            ->limit($this->parameter('limit', 20))
            ->get();

        if ($products->isEmpty()) {
            return null;
        }

        return [
            'result' => $products,
            'title' => $this->parameter('title', __('cms-catalog::site.products.With this product buy')),
        ];
    }
}
