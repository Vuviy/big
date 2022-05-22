<?php

namespace WezomCms\Orders\Contracts;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;

interface CartItemInterface extends Arrayable, Jsonable
{
    /**
     * CartItemInterface constructor.
     * @param  CartInterface  $cart
     * @param  int  $id
     * @param  float  $quantity
     * @param  array  $options
     */
    public function __construct(
        CartInterface $cart,
        int $id,
        float $quantity,
        array $options = []
    );

    /**
     * @param  CartInterface  $cart
     * @return CartItemInterface
     */
    public function setCart(CartInterface $cart): CartItemInterface;

    /**
     * @return string
     */
    public function getUniqueId(): string;

    /**
     * @return int
     */
    public function getId(): int;

    /**
     * Get product price. Without conditions (applied promo, etc).
     */
    public function getOriginalProductPrice(): float;

    /**
     *  Get product purchase price. With conditions (applied promo, etc).
     */
    public function getProductPurchasePrice(): float;

    /**
     * Get sub total cart item price. Without conditions (applied promo, etc).
     */
    public function getSubTotal(): float;

    /**
     * Get crossed out sub total cart item price. Without conditions (applied promo, etc).
     */
    public function crossedOutSubTotal(): float;

    /**
     * Get total cart item price with conditions (applied promo, etc).
     */
    public function getTotal(): float;

    /**
     * Get total discounted price.
     */
    public function totalDiscounted(): float;

    /**
     * @param  string  $condition
     * @return float|int|null
     */
    public function discountedByCondition(string $condition): ?float;

    /**
     * @return Collection
     */
    public function getAppliedConditions(): Collection;

    /**
     * @param  string  $conditionName
     * @return CartItemConditionInterface|null
     */
    public function getAppliedCondition(string $conditionName): ?CartItemConditionInterface;

    /**
     * @param  string  $conditionName
     * @return bool
     */
    public function isAppliedCondition(string $conditionName): bool;

    /**
     * @param  float  $quantity
     * @return CartItemInterface
     */
    public function setQuantity(float $quantity): CartItemInterface;

    /**
     * @return float
     */
    public function getQuantity(): float;

    /**
     * @return Collection
     */
    public function getOptions(): Collection;

    /**
     * @return PurchasedProductInterface|mixed
     */
    public function getPurchaseItem(): PurchasedProductInterface;

    /**
     * @return bool
     */
    public function validate(): bool;
}
