<?php

namespace WezomCms\Catalog\ViewModels;

use Artesaos\SEOTools\Traits\SEOTools;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\ViewModels\ViewModel;
use WezomCms\Catalog\Filter\Contracts\FilterInterface;
use WezomCms\Catalog\Filter\Contracts\SortInterface;

abstract class ProductsListViewModel extends ViewModel
{
    use SEOTools;

    /**
     * @var Request
     */
    public $request;
    /**
     * @var LengthAwarePaginator
     */
    public $products;
    /**
     * @var FilterInterface
     */
    public $filter;
    /**
     * @var SortInterface
     */
    public $sort;
    /**
     * @var \Illuminate\Support\Collection|iterable
     */
    public $searchForm;

    /**
     * ProductsListViewModel constructor.
     * @param  Request  $request
     * @param  Paginator|LengthAwarePaginator  $products
     * @param  FilterInterface  $filter
     * @param  SortInterface  $sort
     */
    public function __construct(Request $request, $products, FilterInterface $filter, SortInterface $sort)
    {
        $this->request = $request;
        $this->products = $products;
        $this->filter = $filter;
        $this->sort = $sort;

        $this->products->onEachSide(1);

        if ($this->request->expectsJson()) {
            $this->searchForm = $this->request->header('x-filter') ? $this->filter->buildWidgetData() : collect();
        } else {
            $this->searchForm = $this->filter->buildWidgetData();
        }
    }

    /**
     * Base url of current page.
     *
     * @return string
     */
    abstract public function baseUrl(): string;

    abstract public function categories(): Collection;

    public function viewCategories(): Collection
    {
        return $this->categories()->map(function ($category) {
            /** @var $category \WezomCms\Catalog\Models\Category */
            return [
                'name' => $category->name,
                'frontUrl' => $category->getFrontUrl(),
                'imageUrl' => $category->getImageUrl('small', 'image'),
            ];
        });
    }

    /**
     * @return iterable
     */
    public function selected(): iterable
    {
        return $this->filter->getSelectedAttributes();
    }

    /**
     * @return Collection
     * @throws \Throwable
     */
    protected function items(): Collection
    {
        if ($this->request->expectsJson()) {
            $pagination = view('cms-catalog::site.partials.products-pagination', ['products' => $this->products])->render();

            $selected = view('cms-catalog::site.partials.selected', [
                'selected' => $this->selected(),
                'baseUrl' => $this->baseUrl()
            ])->render();

            $response = collect([
                'pagination' => $pagination,
                'url' => $this->request->fullUrl(),
                'total' => $this->products->total(),
                'titleDocument' => $this->seo()->getTitle(),
                'langSwitcher' => app('widget')->show('ui:lang-switcher'),
                'selected' => $selected,
            ]);

            // If with filter
            if ($this->request->header('x-filter')) {
                $response->put('filter', view('cms-catalog::site.partials.filter', [
                    'searchForm' => $this->searchForm,
                ])->render());

                $products = view('cms-catalog::site.partials.products', [
                    'products' => $this->products,
                    'filter' => $this->filter
                ])->render();

                $response->put('products', $products);
                $response->put('flags-filter', app('widget')->show('catalog:catalog-flag-filter', ['searchForm' => $this->searchForm]));
            } else {
                $response->put('products', view('cms-catalog::site.partials.products-list', ['products' => $this->products])->render());
            }

            return $response;
        }

        return parent::items();
    }
}
