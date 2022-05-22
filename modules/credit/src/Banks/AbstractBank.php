<?php

namespace WezomCms\Credit\Banks;

use WezomCms\Catalog\Models\Product;

abstract class AbstractBank
{
    /**
     * @param  array|Product  $item
     * @return array
     */
    public function extractProduct($item): array
    {
        if (is_array($item)) {
            /** @var Product $product */
            $product = $item['product'];
            $price = array_get($item, 'price', $product->priceForPurchase());
            $amount = array_get($item, 'amount', $product->minCountForPurchase());

            return compact('product', 'price', 'amount');
        } else {
            return [
                'product' => $item,
                'price' => $item->priceForPurchase(),
                'amount' => $item->minCountForPurchase(),
            ];
        }
    }
}
