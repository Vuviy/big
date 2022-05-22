<?php

namespace WezomCms\Sitemap\Http\Controllers\Site;

use WezomCms\Core\Enums\SeoFields as SeoFieldsEnum;
use WezomCms\Core\Foundation\Helpers;
use WezomCms\Core\Http\Controllers\SiteController;

class SitemapController extends SiteController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke()
    {
        $pageName = __('cms-sitemap::site.Sitemap');

        $this->addBreadcrumb($pageName, route('sitemap'));
        $this->seo()->setPageName($pageName);

        $items = [];
        foreach (event('sitemap:site') as $eventData) {
            $items = array_merge($items, $eventData);
        }

        // Render links only with name
        $items = array_filter($items, function ($item) {
            return !empty($item['name']);
        });

        // Sort items by sort field
        usort($items, function ($a, $b) {
            $aSort = is_array($a)
                ? array_get($a, 'sort', 0)
                : ($a->sort ?? 0);

            $bSort = is_array($b)
                ? array_get($b, 'sort', 0)
                : ($b->sort ?? 0);

            return $aSort <=> $bSort;
        });

        return view('cms-sitemap::site.index', ['items' => Helpers::groupByParentId($items)]);
    }
}
