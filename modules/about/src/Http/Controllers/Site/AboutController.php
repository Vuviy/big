<?php

namespace WezomCms\About\Http\Controllers\Site;

use WezomCms\Core\Http\Controllers\SiteController;

class AboutController extends SiteController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke()
    {
        $siteSettings = settings('about.site', []);

        $this->seo()->fill($siteSettings, false);

        $this->addBreadcrumb(array_get($siteSettings, 'name'), route('about'));

        return view('cms-about::site.index', [
            'siteSettings' => $siteSettings,
        ]);
    }
}
