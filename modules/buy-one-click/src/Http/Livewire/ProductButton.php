<?php

namespace WezomCms\BuyOneClick\Http\Livewire;

use Livewire\Component;
use WezomCms\Catalog\Models\Product;

/**
 * Class ProductButton
 * @package WezomCms\BuyOneClick\Http\Livewire
 * @property Product $product
 */
class ProductButton extends Component
{
    /**
     * @var int
     */
    public $productId;

    /**
     * @var string[]
     */
    protected $listeners = ['updateProductId'];

    /**
     * @param  Product  $product
     */
    public function mount(Product $product)
    {
        $this->productId = $product->id;

        $this->computedPropertyCache['product'] = $product;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render()
    {
        return view(
            'cms-buy-one-click::site.livewire.product-button',
            ['product' => $this->product]
        );
    }

    /**
     * @return Product
     */
    public function getProductProperty(): Product
    {
        return Product::published()
            ->without(['category', 'translation'])
            ->findOrFail($this->productId);
    }

    /**
     * Listen other product components when updated productId property.
     *
     * @param $id
     */
    public function updateProductId($id)
    {
        $this->productId = $id;
    }
}
