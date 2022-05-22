<?php

namespace WezomCms\Catalog\Http\Controllers\Site;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;
use WezomCms\Catalog\Filter\Exceptions\IncorrectUrlParameterException;
use WezomCms\Catalog\Filter\Exceptions\NeedRedirectException;
use WezomCms\Catalog\Filter\Filter;
use WezomCms\Catalog\Filter\Handlers\CategoryWithSubCategoriesHandler;
use WezomCms\Catalog\Filter\Handlers\CostHandler;
use WezomCms\Catalog\Filter\Handlers\ModelHandler;
use WezomCms\Catalog\Filter\Handlers\ProductFlagsHandler;
use WezomCms\Catalog\Filter\Handlers\SpecificationHandler;
use WezomCms\Catalog\Filter\Sort;
use WezomCms\Catalog\Filter\UrlBuilder;
use WezomCms\Catalog\Models\Category;
use WezomCms\Catalog\Models\Product;
use WezomCms\Catalog\ViewModels\CategoryWithProductsViewModel;
use WezomCms\Core\Http\Controllers\SiteController;
use WezomCms\Core\Traits\LoadMoreTrait;
use WezomCms\Core\Traits\RecursiveBreadcrumbsTrait;

class CategoryController extends SiteController
{
    use LoadMoreTrait;
    use RecursiveBreadcrumbsTrait;

    /**
     * @param $slug
     * @param $id
     * @param Request $request
     * @return mixed|void
     * @throws \Throwable
     */
    public function __invoke($slug, $id, Request $request)
    {
        $category = Category::published()->findOrFail($id);

        // Redirect to new slug
        if ($category->slug !== $slug) {
            return redirect($category->getFrontUrl(), 301);
        }

        if (!$request->expectsJson()) {
            $this->addBreadcrumb(
                settings('categories.site.name', __('cms-catalog::site.catalog.Catalog')),
                route('catalog')
            );
            $this->addRecursiveBreadcrumbs($category);
        }

        try {
            $urlBuilder = (new UrlBuilder('catalog.category.filter', 'catalog.category'))
                ->setRouteParameters(['slug' => $category->slug, 'id' => $category->id])
                ->setRequest($request);

            $filter = new Filter(new Product(), $urlBuilder);

            // Sorting
            $sort = new Sort($request);

            // Set handlers
            $filter->addHandlers([
                (new CategoryWithSubCategoriesHandler($filter))->setCategory($category),
                new ProductFlagsHandler($filter),
                new ModelHandler($filter),
                new CostHandler($filter),
                new SpecificationHandler($filter),
                $sort,
            ]);

            $filter->start();

            /** @var Paginator $products */
            $products = $filter->getFilteredItems(settings('categories.site.limit', 16));

            return (new CategoryWithProductsViewModel($category, $request, $products, $filter, $sort))
                ->view('cms-catalog::site.catalog.index');
        } catch (NeedRedirectException $e) {
            return redirect()->route('catalog.category.filter', [$category->slug, $category->id, $e->getUrl()]);
        } catch (IncorrectUrlParameterException $e) {
            abort(404);
        }
    }
}
