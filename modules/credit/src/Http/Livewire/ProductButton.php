<?php

namespace WezomCms\Credit\Http\Livewire;

use Livewire\Component;
use WezomCms\Catalog\Models\Product;
use WezomCms\Core\Foundation\JsResponse;
use WezomCms\Credit\Drivers\Credit;
use WezomCms\Credit\Exceptions\CreditServiceException;
use WezomCms\Orders\Contracts\CartInterface;

/**
 * Class ProductPopup
 * @package WezomCms\Credit\Http\Livewire
 * @property Product $product
 */
class ProductButton extends Component
{
    /**
     * @var int
     */
    public $productId;

    /**
     * @param  Product  $product
     */
    public function mount(Product $product)
    {
        $this->productId = $product->getKey();

        $this->computedPropertyCache['product'] = $product;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     * @throws CreditServiceException
     */
    public function render()
    {
        return view('cms-credit::site.livewire.product-button');
    }

    public function addToCart()
    {
        $product = $this->product;

        $cart = app(CartInterface::class);

        if (!$product->in_cart) {
            if (!$this->product->availableForPurchase()) {
                JsResponse::make()
                    ->success(false)
                    ->notification(__('cms-orders::site.cart.Product cannot be purchased'), 'error')
                    ->emit($this);
                return;
            }

            $cart->add($product->id, $product->minCountForPurchase());
        }

        session()->flash('checkout-payment', [
            'driver' => Credit::DRIVER,
        ]);

        $this->redirectRoute('checkout');
    }

    /**
     * @return Product
     */
    public function getProductProperty(): Product
    {
        return Product::published()->findOrFail($this->productId);
    }
}
