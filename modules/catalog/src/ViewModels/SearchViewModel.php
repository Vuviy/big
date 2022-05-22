<?php

namespace WezomCms\Catalog\ViewModels;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use WezomCms\Catalog\Filter\Contracts\FilterInterface;
use WezomCms\Catalog\Filter\Contracts\SortInterface;
use WezomCms\Catalog\Filter\SelectionHandlers\KeywordSearch;
use WezomCms\Catalog\Models\Category;
use WezomCms\Core\Traits\BreadcrumbsTrait;

class SearchViewModel extends ProductsListViewModel
{
    use BreadcrumbsTrait;

    /**
     * @var string|null
     */
    public $query;

    /**
     * @var Category|null
     */
    public $currentCategory;

    /**
     * @var KeywordSearch
     */
    private $search;

    /**
     * SearchViewModel constructor.
     * @param  string|null  $query
     * @param  KeywordSearch  $search
     * @param  Category|null  $currentCategory
     * @param  Request  $request
     * @param $products
     * @param  FilterInterface  $filter
     * @param  SortInterface  $sort
     */
    public function __construct(
        ?string $query,
        KeywordSearch $search,
        ?Category $currentCategory,
        Request $request,
        $products,
        FilterInterface $filter,
        SortInterface $sort
    ) {
        $this->query = $query;
        $this->currentCategory = $currentCategory;
        $this->search = $search;

        parent::__construct($request, $products, $filter, $sort);

        $this->setSeo();
    }

    /**
     * Base url of current page.
     *
     * @return string
     */
    public function baseUrl(): string
    {
        return route('search');
    }

    /**
     * Reset url of current page.
     *
     * @return string
     */
    public function resetUrl(): string
    {
        return route('search', ['search' => e($this->query)]);
    }

    public function categories(): Collection
    {
        if (!isset($this->currentCategory)) {
            return Category::root()
                ->whereHas('children.children.products', function ($query) {
                    $this->search->apply($query);
                    $query->published();
                })
                ->published()
                ->sorting()
                ->limit(settings('categories.site.categories_limit', 10))
                ->get();
        }

        if (is_null($this->currentCategory->parent_id)) {
            return $this->currentCategory->children()
                ->whereHas('children.products', function ($query) {
                    $this->search->apply($query);
                    $query->published();
                })
                ->published()
                ->sorting()
                ->limit(settings('categories.site.categories_limit', 10))
                ->get();
        }

        return $this->currentCategory->children()
            ->whereHas('products',  function ($query) {
                $this->search->apply($query);
                $query->published();
            })
            ->published()
            ->sorting()
            ->limit(settings('categories.site.categories_limit', 10))
            ->get();
    }

    public function viewCategories(): Collection
    {
        return $this->categories()->map(function ($category) {
            /** @var $category \WezomCms\Catalog\Models\Category */
            return [
                'name' => $category->name,
                'frontUrl' => route('search', ['search' => e($this->query), 'category' => $category->slug]),
                'imageUrl' => $category->getImageUrl('small', 'image'),
            ];
        });
    }

    /**
     * @return array
     */
    public function queryParams(): array
    {
        $params = ['search' => $this->query];
        if ($this->currentCategory) {
            $params['category'] = $this->currentCategory->slug;
        }

        return $params;
    }

    /**
     * Generate seo meta attributes
     */
    private function setSeo()
    {
        $settings = settings('search.search', []);

        $this->seo()->fill($settings, false)->noIndex('noindex, nofollow')->setPrevNext($this->products);

        $this->addBreadcrumb(array_get($settings, 'name'));
    }
}
