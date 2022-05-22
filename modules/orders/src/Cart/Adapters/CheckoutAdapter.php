<?php

namespace WezomCms\Orders\Cart\Adapters;

use WezomCms\Catalog\Models\Product;
use WezomCms\Orders\Contracts\CartAdapterInterface;
use WezomCms\Orders\Contracts\CartInterface;
use WezomCms\Orders\Contracts\CartItemInterface;

class CheckoutAdapter implements CartAdapterInterface
{
    /**
     * @var CartInterface
     */
    private $cart;

    /**
     * JsonAdapter constructor.
     * @param  CartInterface  $cart
     */
    public function __construct(CartInterface $cart)
    {
        $this->cart = $cart;
    }

    /**
     * Adapt data to concrete template.
     *
     * @return mixed
     */
    public function adapt()
    {
        return [
            'items' => $this->getItems(),
            'total' => $this->cart->total(),
            'sub_total' => $this->cart->subTotal(),
            'items_quantity' => $this->cart->quantity(),
        ];
    }

    /**
     * @return array
     */
    protected function getItems(): array
    {
        return $this->cart->content()->map(function (CartItemInterface $cartItem) {
            /** @var Product $product */
            $product = $cartItem->getPurchaseItem();

            return [
                'product' => $product,
                'quantity' => [
                    'value' => $cartItem->getQuantity(),
                ],
                'sub_total' => $cartItem->getSubTotal(),
            ];
        })->all();
    }
}
