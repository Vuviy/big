<?php

namespace WezomCms\News\Http\Controllers\Admin;

use WezomCms\Core\Http\Controllers\AbstractCRUDController;
use WezomCms\Core\Traits\AjaxResponseStatusTrait;
use WezomCms\News\Http\Requests\Admin\NewsTagRequest;
use WezomCms\News\Models\NewsTag;

class NewsTagsController extends AbstractCRUDController
{
    use AjaxResponseStatusTrait;

    /**
     * Model name.
     *
     * @var string
     */
    protected $model = NewsTag::class;

    /**
     * Base view path name.
     *
     * @var string
     */
    protected $view = 'cms-news::admin.tags';

    /**
     * Resource route name.
     *
     * @var string
     */
    protected $routeName = 'admin.news-tags';

    /**
     * Form request class name.
     *
     * @var string
     */
    protected $request = NewsTagRequest::class;

    /**
     * Resource name for breadcrumbs and title.
     *
     * @return string
     */
    protected function title(): string
    {
        return __('cms-news::admin.Tags');
    }
}
