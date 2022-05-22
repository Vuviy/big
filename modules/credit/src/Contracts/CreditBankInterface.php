<?php

namespace WezomCms\Credit\Contracts;

use Illuminate\Support\Collection;
use WezomCms\Catalog\Models\Product;
use WezomCms\Credit\Bank;
use WezomCms\Credit\Exceptions\CreditServiceException;
use WezomCms\Orders\Models\Order;

interface CreditBankInterface
{
    /**
     * Check service state and ready for use.
     *
     * @return bool
     */
    public function validate(): bool;

    /**
     * @return string
     */
    public static function getType(): string;

    /**
     * @param $items Collection|Product[]
     * @param  null  $price
     * @return Collection
     * @throws CreditServiceException
     */
    public function monthCount(Collection $items, $price = null): Collection;

    /**
     * @param  Collection|Product[]  $items
     * @param  int  $month
     * @return Bank|null
     * @throws CreditServiceException
     */
    public function bank(Collection $items, int $month): ?Bank;

    /**
     * @param  Product  $product
     * @param  int|null  $month
     * @param  null  $price
     * @return int|float|null
     */
    public function minimumPayment(Product $product, ?int $month = null, $price = null): ?float;

    /**
     * Generate link to credit system.
     *
     * @param  Order  $order
     * @return string|null
     */
    public function redirectUrl(Order $order): ?string;

    /**
     * @param  Order  $order
     * @return mixed
     */
    public function sendRequestToService(Order $order);
}
