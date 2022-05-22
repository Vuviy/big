<?php

namespace WezomCms\Catalog\Widgets\Site;

use WezomCms\Catalog\Models\Product;
use WezomCms\Core\Foundation\Widgets\AbstractWidget;

abstract class BaseProductsCarouselByFlag extends AbstractWidget
{
    public const LIMIT = 12;

    /**
     * The number of minutes before cache expires.
     * False means no caching at all.
     * If debug mode is on - the widget will not be cached.
     *
     * @var int|float|bool
     */
    public $cacheTime = 5;

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
        $result = Product::getByFlag($this->flagName(), $this->limit());

        if ($result->isEmpty()) {
            return null;
        }

        return [
            'result' => $result,
            'title' => $this->heading(),
            'catalogLinkName' => $this->catalogLinkName(),
            'catalogLinkUrl' => $this->catalogLinkUrl(),
        ];
    }

    /**
     * Return product field name for filtering.
     *
     * @return string
     */
    abstract public function flagName(): string;

    public function limit(): int
    {
        return static::LIMIT;
    }

    /**
     * Return widget heading.
     *
     * @return string|null
     */
    abstract public function heading(): ?string;

    public function catalogLinkUrl(): ?string
    {
        return route_localized('catalog.filter', ['filter' => $this->flagName() . '=1']);
    }

    abstract public function catalogLinkName(): ?string;
}
