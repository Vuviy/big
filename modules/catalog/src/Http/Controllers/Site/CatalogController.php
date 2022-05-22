<?php

namespace WezomCms\Catalog\Http\Controllers\Site;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;
use WezomCms\Catalog\Filter\Exceptions\IncorrectUrlParameterException;
use WezomCms\Catalog\Filter\Exceptions\NeedRedirectException;
use WezomCms\Catalog\Filter\Filter;
use WezomCms\Catalog\Filter\Handlers\CostHandler;
use WezomCms\Catalog\Filter\Handlers\ProductFlagsHandler;
use WezomCms\Catalog\Filter\Sort;
use WezomCms\Catalog\Filter\UrlBuilder;
use WezomCms\Catalog\Models\Product;
use WezomCms\Catalog\ViewModels\SimpleViewModel;
use WezomCms\Core\Http\Controllers\SiteController;
use WezomCms\Core\Traits\LoadMoreTrait;

class CatalogController extends SiteController
{
    use LoadMoreTrait;

    /**
     * @return mixed
     * @throws \Throwable
     */
    public function __invoke(Request $request)
    {
        $settings = settings('categories', []);

        try {
            $urlBuilder = (new UrlBuilder('catalog.filter', 'catalog'))->setRequest($request);

            $filter = new Filter(new Product(), $urlBuilder);

            // Sorting
            $sort = new Sort($request);

            // Set handlers
            $filter->addHandlers([
                new ProductFlagsHandler($filter),
                new CostHandler($filter),
                $sort,
            ]);

            $filter->start();

            /** @var Paginator $products */
            $products = $filter->getFilteredItems(settings('categories.site.limit', 16));

            return (new SimpleViewModel($settings, 'catalog', __('cms-catalog::site.catalog.Catalog'), $request, $products, $filter, $sort))
                ->view('cms-catalog::site.catalog.index');
        } catch (NeedRedirectException $e) {
            return redirect()->route('catalog.filter', [$e->getUrl()]);
        } catch (IncorrectUrlParameterException $e) {
            abort(404);
        }
    }
}
