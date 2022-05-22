<?php

namespace WezomCms\Orders\Http\Livewire;

use Livewire\Component;
use WezomCms\Orders\Contracts\CartInterface;

class HeaderCartButton extends Component
{
    /**
     * Register component listeners.
     *
     * @var string[]
     */
    protected $listeners = ['cartUpdated' => '$refresh'];

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(CartInterface $cart)
    {
        $count = $cart->count();

        return view('cms-orders::site.livewire.header-cart-button', compact('count'));
    }

    /**
     * @param  CartInterface  $cart
     * @param  string  $rowId
     */
    public function deleteItemFromCart(CartInterface $cart, string $rowId)
    {
        if ($cartItem = $cart->get($rowId)) {
            $cart->remove($cartItem->getUniqueId());

            $this->emit('cartItemRemoved:' . $cartItem->getId());
        }
    }
}
