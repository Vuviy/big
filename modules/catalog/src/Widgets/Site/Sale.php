<?php

namespace WezomCms\Catalog\Widgets\Site;

class Sale extends BaseProductsCarouselByFlag
{
    /**
     * Return product field name for filtering.
     *
     * @return string
     */
    public function flagName(): string
    {
        return 'sale';
    }

    /**
     * Return widget heading.
     *
     * @return string|null
     */
    public function heading(): ?string
    {
        return __('cms-catalog::site.products.Sale products');
    }

    public function catalogLinkName(): ?string
    {
        return __('cms-catalog::site.flags.All sale');
    }

    /**
     * Return count items
     * @return int
     */
    public function limit(): int
    {
        return 12;
    }
}
