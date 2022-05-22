<?php

namespace WezomCms\Catalog\ViewModels;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use WezomCms\Catalog\Filter\Contracts\FilterInterface;
use WezomCms\Catalog\Filter\Contracts\SortInterface;
use WezomCms\Catalog\Models\Category;
use WezomCms\Core\Traits\BreadcrumbsTrait;
use WezomCms\Core\Traits\LangSwitchingGenerator;

class SimpleViewModel extends ProductsListViewModel
{
    use LangSwitchingGenerator;
    use BreadcrumbsTrait;

    public $settings;
    /**
     * @var string
     */
    private $baseRouteName;
    /**
     * @var string
     */
    private $baseFilterRouteName;
    /**
     * @var string
     */
    private $pageName;

    /**
     * @param  Request  $request
     * @param  Paginator|LengthAwarePaginator  $products
     * @param  FilterInterface  $filter
     * @param  SortInterface  $sort
     * @throws \Exception
     */
    public function __construct(
        array $settings,
        string $baseRouteName,
        string $pageName,
        Request $request,
        $products,
        FilterInterface $filter,
        SortInterface $sort
    ) {
        $this->settings = $settings;
        $this->baseRouteName = $baseRouteName;
        $this->baseFilterRouteName = $baseRouteName . 'filter';
        $this->pageName = $pageName;
        parent::__construct($request, $products, $filter, $sort);

        // Seo
        $this->setSeo();
    }

    /**
     * @inheritDoc
     */
    public function baseUrl(): string
    {
        return route($this->baseRouteName);
    }

    protected function pageName()
    {
        return $this->pageName;
    }

    public function categories(): Collection
    {
        return Category::root()
            ->whereHas('children.children.products', published_scope())
            ->published()
            ->sorting()
            ->limit(settings('categories.site.categories_limit', 10))
            ->get();
    }

    /**
     * Generate seo meta attributes.
     *
     * @throws \Exception
     */
    protected function setSeo()
    {
        // Breadcrumbs
        $this->addBreadcrumb(array_get($this->settings, 'site.name', $this->pageName()), $this->baseUrl());

        $title = array_get($this->settings, 'site.title', $this->pageName());
        $h1 = array_get($this->settings, 'site.h1', $this->pageName());
        $description = array_get($this->settings, 'site.description', '');
        $keywords = array_get($this->settings, 'site.keywords', '');
        $seoText = array_get($this->settings, 'site.text', '');

        /** @var Collection $selectedAttributes */
        $selectedAttributes = $this->filter->getSelectedAttributes()->map(function ($item) {
            return array_get($item, 'name');
        })->filter();

        if ($selectedAttributes->isNotEmpty()) {
            $title .= ' - ' . $selectedAttributes->implode(', ');
        }

        if ($this->sort->urlHasSortKey() || $this->filter->getUrlBuilder()->getParameters()) {
            $this->seo()
                ->setCanonical($this->baseUrl())
                ->metatags()
                ->addMeta('robots', 'noindex, nofollow');
        }

        if ($this->products->currentPage() > 1) {
            $this->seo()
                ->metatags()
                ->setDescription(null);
        }


        if ($this->sort->urlHasSortKey()) {
            $title .= " - {$this->sort->getCurrentSortName()}";
        }

        // SEO
        $this->seo()
            ->setTitle($title)
            ->setPageName($title)
            ->setH1($h1)
            ->setSeoText($seoText)
            ->setDescription($description)
            ->metatags()
            ->setKeywords($keywords)
            ->setNext($this->products->nextPageUrl())
            ->setPrev($this->products->previousPageUrl());

        if ($this->sort->urlHasSortKey()) {
            $this->seo()
                ->metatags()
                ->setDescription(null);
        }

        // Lang switchers
        $this->setLangSwitchersByRoute($this->baseRouteName);
    }
}
