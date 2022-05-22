<?php

namespace WezomCms\Seo\Http\Controllers\Admin;

use WezomCms\Core\Http\Controllers\AbstractCRUDController;
use WezomCms\Seo\Http\Requests\Admin\LinkRequest;
use WezomCms\Seo\Models\SeoLink;

class LinksController extends AbstractCRUDController
{
    /**
     * Model name.
     *
     * @var string
     */
    protected $model = SeoLink::class;

    /**
     * Resource route name.
     *
     * @var string
     */
    protected $routeName = 'admin.seo-links';

    /**
     * Base view path name.
     *
     * @var string
     */
    protected $view = 'cms-seo::admin.links';

    /**
     * Form request class name.
     *
     * @var string
     */
    protected $request = LinkRequest::class;

    /**
     * Resource name for breadcrumbs and title.
     *
     * @return string
     */
    protected function title(): string
    {
        return __('cms-seo::admin.links.Links');
    }
}
