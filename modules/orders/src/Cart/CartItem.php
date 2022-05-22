<?php

namespace WezomCms\Orders\Cart;

use Illuminate\Support\Collection;
use WezomCms\Catalog\Models\Product;
use WezomCms\Orders\Contracts\CartInterface;
use WezomCms\Orders\Contracts\CartItemConditionInterface;
use WezomCms\Orders\Contracts\CartItemInterface;
use WezomCms\Orders\Contracts\PurchasedProductInterface;

class CartItem implements CartItemInterface
{
    /**
     * @var string
     */
    private $uniqueId;
    /**
     * @var int
     */
    private $id;
    /**
     * @var float
     */
    private $quantity;
    /**
     * @var Collection
     */
    private $options;
    /**
     * @var PurchasedProductInterface|null
     */
    private $purchaseItem;
    /**
     * @var CartInterface
     */
    private $cart;

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
    ) {
        $this->id = $id;
        $this->quantity = $quantity;
        $this->options = collect($options);

        $this->uniqueId = $this->generateUniqueId();

        $this->cart = $cart;

        $this->loadPurchaseItem();
    }

    /**
     * @param  CartInterface  $cart
     * @return CartItemInterface
     */
    public function setCart(CartInterface $cart): CartItemInterface
    {
        $this->cart = $cart;

        return $this;
    }

    /**
     * @return string
     */
    public function getUniqueId(): string
    {
        return $this->uniqueId;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get product price. Without conditions (applied promo, etc).
     */
    public function getOriginalProductPrice(): float
    {
        return $this->purchaseItem->priceForPurchase();
    }

    /**
     *  Get product purchase price. With conditions (applied promo, etc).
     */
    public function getProductPurchasePrice(): float
    {
        return $this->getTotal() / $this->getQuantity();
    }

    /**
     * Get sub total cart item price. Without conditions (applied promo, etc).
     */
    public function getSubTotal(): float
    {
        return $this->round($this->getQuantity() * $this->purchaseItem->priceForPurchase());
    }

    /**
     * Get crossed out sub total cart item price. Without conditions (applied promo, etc).
     */
    public function crossedOutSubTotal(): float
    {
        $price = $this->purchaseItem->oldPriceForPurchase() ?: $this->purchaseItem->priceForPurchase();

        return $this->round($this->getQuantity() * $price);
    }

    /**
     * Get total cart item price with conditions (applied promo, etc).
     */
    public function getTotal(): float
    {
        $price = $this->getSubTotal();

        // If enabled cart conditions
        if (method_exists($this->cart, 'getItemConditions')) {
            foreach ($this->cart->getItemConditions() as $condition) {
                /** @var CartItemConditionInterface $condition */
                if ($condition->isApplicable($this)) {
                    $price = $condition->apply($this, $price);
                }
            }
        }

        return $price;
    }

    /**
     * Get total discounted price.
     */
    public function totalDiscounted(): float
    {
        return $this->round($this->getSubTotal() - $this->getTotal());
    }

    /**
     * @param  string  $condition
     * @return float|int|null
     */
    public function discountedByCondition(string $condition): ?float
    {
        if (!$this->isAppliedCondition($condition)) {
            return 0;
        }

        $condition = $this->getAppliedCondition($condition);

        if (!$condition->isApplicable($this)) {
            return 0;
        }

        $price = $this->getSubTotal();

        $discountedPrice = $condition->apply($this, $price);

        return $this->round($price - $discountedPrice);
    }

    /**
     * @return Collection
     */
    public function getAppliedConditions(): Collection
    {
        if (method_exists($this->cart, 'getItemConditions')) {
            return $this->cart->getItemConditions()
                ->filter(function (CartItemConditionInterface $condition) {
                    return $condition->isApplicable($this);
                });
        } else {
            return collect();
        }
    }

    /**
     * @param  string  $conditionName
     * @return CartItemConditionInterface|null
     */
    public function getAppliedCondition(string $conditionName): ?CartItemConditionInterface
    {
        $appliedConditions = $this->getAppliedConditions();

        $index = $appliedConditions->search(function (CartItemConditionInterface $condition) use ($conditionName) {
            return $condition instanceof $conditionName;
        });

        return $appliedConditions->get($index);
    }

    /**
     * @param  string  $conditionName
     * @return bool
     */
    public function isAppliedCondition(string $conditionName): bool
    {
        return $this->getAppliedConditions()
            ->filter(function (CartItemConditionInterface $condition) use ($conditionName) {
                return $condition instanceof $conditionName;
            })
            ->isNotEmpty();
    }

    /**
     * @param  float  $quantity
     * @return CartItemInterface
     */
    public function setQuantity(float $quantity): CartItemInterface
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return float
     */
    public function getQuantity(): float
    {
        return round($this->quantity, $this->cart->getQuantityPrecision());
    }

    /**
     * @return Collection
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    /**
     * @param  Collection  $options
     * @return CartItemInterface
     */
    public function setOptions(Collection $options): CartItemInterface
    {
        $this->options = $options;

        $this->loadPurchaseItem(); // Fresh purchased product state with some relations.

        return $this;
    }

    /**
     * @return PurchasedProductInterface|Product|mixed
     */
    public function getPurchaseItem(): PurchasedProductInterface
    {
        return $this->purchaseItem;
    }

    /**
     * @return bool
     */
    public function validate(): bool
    {
        return $this->purchaseItem !== null;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'unique_id' => $this->getUniqueId(),
            'id' => $this->getId(),
            'quantity' => $this->getQuantity(),
            'options' => $this->getOptions(),
        ];
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int  $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    /**
     * @return array
     */
    public function __sleep()
    {
        return array_filter(array_keys(get_object_vars($this)), function ($key) {
            return !in_array($key, ['cart', 'purchaseItem']);
        });
    }

    /**
     * @return void
     */
    public function __wakeup()
    {
        $this->loadPurchaseItem();
    }

    /**
     * @return string
     */
    protected function generateUniqueId()
    {
        return md5($this->id . serialize($this->options->sortKeys()));
    }

    /**
     * @param $value
     * @return float
     */
    protected function round($value): float
    {
        return round($value, $this->cart->getPrecision());
    }

    protected function loadPurchaseItem()
    {
        $this->purchaseItem = Product::published()->find($this->getId());
    }
}
