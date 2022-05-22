<?php

namespace WezomCms\Orders\Contracts;

interface PurchasedProductInterface
{
    /**
     * @return bool
     */
    public function availableForPurchase(): bool;

    /**
     * @return string|null
     */
    public function unit(): ?string;

    /**
     * @return float|int
     */
    public function minCountForPurchase();

    /**
     * @return float|int
     */
    public function stepForPurchase();

    /**
     * @param  float  $quantity
     * @return bool
     */
    public function validatePurchaseQuantity(float $quantity): bool;

    /**
     * Product purchased price.
     *
     * @return float|int
     */
    public function priceForPurchase();

    /**
     * Product old price.
     *
     * @return float|int|null
     */
    public function oldPriceForPurchase();
}
