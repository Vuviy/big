<?php

namespace WezomCms\Catalog\Widgets\Site;

class Popular extends BaseProductsCarouselByFlag
{
    /**
     * Return product field name for filtering.
     *
     * @return string
     */
    public function flagName(): string
    {
        return 'popular';
    }

    /**
     * Return widget heading.
     *
     * @return string|null
     */
    public function heading(): ?string
    {
        return __('cms-catalog::site.products.Popular products');
    }

    public function catalogLinkName(): ?string
    {
        return __('cms-catalog::site.flags.All popular');
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
