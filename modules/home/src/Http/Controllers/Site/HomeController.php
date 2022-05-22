<?php

namespace WezomCms\Home\Http\Controllers\Site;

use WezomCms\Core\Http\Controllers\SiteController;

class HomeController extends SiteController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke()
    {
        $this->seo()->fill(settings('home.site', []));

        return view('cms-home::site.home');
    }
}
