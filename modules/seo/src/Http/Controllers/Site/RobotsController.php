<?php

namespace WezomCms\Seo\Http\Controllers\Site;

use WezomCms\Core\Http\Controllers\SiteController;

class RobotsController extends SiteController
{
    /**
     * @return mixed|\WezomCms\Core\Contracts\SettingsInterface
     */
    public function __invoke()
    {
        return response(strip_tags(settings('seo.robots.content')));
    }
}
