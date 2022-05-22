<?php

namespace WezomCms\PrivacyPolicy\Http\Controllers\Site;

use WezomCms\Core\Http\Controllers\SiteController;

class PrivacyPolicyController extends SiteController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke()
    {
        $settings = settings('privacy-policy.site', []);

        $this->addBreadcrumb(array_get($settings, 'name'), route('privacy-policy'));
        $this->seo()->fill($settings, false);

        return view('cms-privacy-policy::site.index', ['settings' => $settings]);
    }
}
