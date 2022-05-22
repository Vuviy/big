<?php

namespace WezomCms\Orders\Cart\Storage;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use WezomCms\Orders\Contracts\CartItemInterface;
use WezomCms\Orders\Contracts\NeedClearOldHashesInterface;
use WezomCms\Orders\Models\Cart;
use WezomCms\Orders\Models\CartItem;

class DatabaseStorage extends AbstractStorage implements NeedClearOldHashesInterface
{
    /**
     * @var Cart
     */
    private $mainCart;
    /**
     * @var bool
     */
    private $runningInConsole;

    /**
     * DatabaseStorage constructor.
     * @param  int  $precision
     * @param  int  $quantityPrecision
     */
    public function __construct(int $precision = 0, int $quantityPrecision = 0)
    {
        parent::__construct($precision, $quantityPrecision);

        $this->runningInConsole = app()->runningInConsole();

        if ($this->runningInConsole) {
            $this->mainCart = new Cart();
        } else {
            $this->restoreCart();
        }
    }

    /**
     * Load cart and cart items from database.
     */
    protected function restoreCart()
    {
        $this->mainCart = Cart::firstOrCreate(['hash' => $this->makeHash()]);

        $this->items = $this->mainCart->items->pluck('content', 'unique_id')->map(function ($value) {
            try {
                return unserialize($value)->setCart($this);
            } catch (ModelNotFoundException $e) {
                return false;
            }
        })->filter()->filter(function (CartItemInterface $cartItem) {
            return $cartItem->validate();
        });

        foreach ((array) $this->mainCart->conditions as $condition) {
            $this->applyCondition(unserialize($condition));
        }
    }

    /**
     * @param  CartItemInterface  $item
     * @return bool
     */
    public function insert(CartItemInterface $item): bool
    {
        $uniqueId = $item->getUniqueId();

        if ($this->has($uniqueId)) {
            $row = $this->mainCart->items()->where('unique_id', $uniqueId)->first();
        } else {
            $row = new CartItem();
            $row->unique_id = $uniqueId;
            $row->cart()->associate($this->mainCart);
        }
        $row->content = serialize($item);

        if ($result = $row->save()) {
            $this->items->put($uniqueId, $item);
        }

        return $result;
    }

    /**
     * @param  string  $uniqueId
     * @return bool
     */
    public function remove(string $uniqueId): bool
    {
        $this->mainCart->items()->where('unique_id', $uniqueId)->delete();
        if ($this->items->has($uniqueId)) {
            $this->items->forget($uniqueId);
        }

        return parent::remove($uniqueId);
    }

    /**
     * @return bool
     */
    public function clear(): bool
    {
        try {
            $this->mainCart->delete();
        } catch (\Exception $e) {
            return false;
        }

        $this->items = collect();

        $this->clearConditions();

        return true;
    }

    /**
     * @return bool
     */
    public function clearOldHashes(): bool
    {
        try {
            Cart::where('created_at', '<', now()->subDay())
                ->whereDoesntHave('items')
                ->delete();
        } catch (\Exception $e) {
            logger($e->getMessage());

            return false;
        }

        return true;
    }

    public function __destruct()
    {
        if ($this->runningInConsole) {
            return;
        }

        $conditions = $this->getConditions()
            ->map(function ($condition) {
                return serialize($condition);
            })->toArray();

        $this->mainCart->conditions = $conditions;
        $this->mainCart->save();

        $this->items->map(function (CartItemInterface $cartItem) {
            $this->mainCart->items()
                ->where('unique_id', $cartItem->getUniqueId())
                ->update(['content' => serialize($cartItem)]);
        });
    }
}
