<?php

namespace WezomCms\Catalog\Traits;

use Lang;

trait PurchasedProductTrait
{
    /**
     * @return bool
     */
    public function availableForPurchase(): bool
    {
        return $this->available;
    }

    /**
     * @return string|null
     */
    public function unit(): ?string
    {
        return Lang::get('cms-catalog::' . app('side') . '.products.pieces');
    }

    /**
     * @return float|int
     */
    public function minCountForPurchase()
    {
        return 1;
    }

    /** @TODO maxCountForPurchase() */
    public function maxCountForPurchase()
    {
        return 9999;
    }

    /**
     * @return float|int
     */
    public function stepForPurchase(): float
    {
        return 1;
    }

    /**
     * Product purchased price.
     *
     * @return float|int
     */
    public function priceForPurchase()
    {
        return $this->cost;
    }

    /**
     * @param  float  $quantity
     * @return bool
     */
    public function validatePurchaseQuantity(float $quantity): bool
    {
        return $this->minCountForPurchase() <= $quantity
            && $quantity <= $this->maxCountForPurchase()
            && ($quantity - $this->minCountForPurchase()) % $this->stepForPurchase() === 0;
    }

    public function canDecreaseQuantity(int $count): bool
    {
        return $count - $this->stepForPurchase() >= $this->minCountForPurchase();
    }

    public function canIncreaseQuantity(int $count): bool
    {
        return $count + $this->stepForPurchase() <= $this->maxCountForPurchase();
    }

    /**
     * Product old price.
     *
     * @return float|int|null
     */
    public function oldPriceForPurchase()
    {
        return $this->sale && $this->old_cost > $this->cost ? $this->old_cost : null;
    }
}
