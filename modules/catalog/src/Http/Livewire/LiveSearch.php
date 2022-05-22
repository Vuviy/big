<?php

namespace WezomCms\Catalog\Http\Livewire;

use Livewire\Component;
use WezomCms\Catalog\Filter\SelectionHandlers\KeywordSearch;
use WezomCms\Catalog\Models\Product;

class LiveSearch extends Component
{
    protected const PRODUCTS_LIMIT = 4;

    /**
     * @var string
     */
    public $search;

    /**
     * @var \Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Collection
     */
    public $products;

    /**
     * @var int
     */
    public $productCount;

    public function mount()
    {
        $this->products = collect();
        $this->productCount = 0;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render()
    {
        return view('cms-catalog::site.livewire.live-search');
    }

    public function send()
    {
        $this->validate(...$this->rules());

        $search = new KeywordSearch($this->search);

        // Search products
        $productsQuery = Product::query();

        $search->apply($productsQuery);

        $productIds = $productsQuery->published()->withoutTrashed()->sorting()->getQuery()->pluck('id');

        $productLimitIds = $productIds->take(static::PRODUCTS_LIMIT);

        if (!$productLimitIds->isEmpty()) {
            $this->products = Product::whereIn('id', $productLimitIds)
                ->with('mainImage')
                ->published()
                ->sorting()
                ->get();
        } else {
            $this->products = collect();
        }

        $this->productCount = $productIds->count();
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function updatedSearch()
    {
        $this->send();
    }

    /**
     * @return array
     */
    protected function rules(): array
    {
        return [
            ['search' => 'required|string|min:3'],
            [],
            ['search' => __('cms-catalog::site.search.Search query')]
        ];
    }
}
