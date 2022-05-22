<?php

namespace WezomCms\Catalog\Widgets\Site;

class Novelty extends BaseProductsCarouselByFlag
{
    /**
     * Return product field name for filtering.
     *
     * @return string
     */
    public function flagName(): string
    {
        return 'novelty';
    }

    /**
     * Return widget heading.
     *
     * @return string|null
     */
    public function heading(): ?string
    {
        return __('cms-catalog::site.products.Novelty products');
    }

    public function catalogLinkName(): ?string
    {
        return __('cms-catalog::site.flags.All novelty');
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
