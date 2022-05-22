<?php

namespace WezomCms\Catalog\Widgets\Admin;

use WezomCms\Catalog\Models\Product;
use WezomCms\Catalog\Models\Specifications\Specification;
use WezomCms\Catalog\Models\Specifications\SpecValue;
use WezomCms\Core\Foundation\Widgets\AbstractWidget;

class ProductSpecificationsTab extends AbstractWidget
{
    /**
     * View name.
     *
     * @var string|null
     */
    protected $view = 'cms-catalog::admin.widgets.product-specifications-tab';

    /**
     * @return array|null
     */
    public function execute(): ?array
    {
        if (!$categoryId = $this->parameter('categoryId')) {
            return null;
        }

        $specifications = Specification::whereHas('categories', function ($builder) use ($categoryId) {
            $builder->whereKey($categoryId);
        })->sorting()
            ->get();

        $selectedPrimarySpecValues = collect();
        $selectedSpecifications = [];

        /** @var Product|null $product */
        if ($product = $this->parameter('product')) {
            $specIds = $specifications->pluck('id');

            $selectedPrimarySpecValues = $product->primarySpecValues
                ->filter(function (SpecValue $specValue) use ($specIds) {
                    return $specIds->contains($specValue->specification_id);
                });

            $specValues = $product->specificationsValues->filter(function (SpecValue $specValue) use ($specIds) {
                return $specIds->contains($specValue->specification_id);
            });

            foreach ($specValues as $specValue) {
                $selectedSpecifications[$specValue->specification_id][$specValue->id] = $specValue->name;
            }
        }

        return compact('specifications', 'selectedPrimarySpecValues', 'selectedSpecifications');
    }
}
