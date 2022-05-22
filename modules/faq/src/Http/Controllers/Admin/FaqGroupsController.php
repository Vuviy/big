<?php

namespace WezomCms\Faq\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use WezomCms\Core\Http\Controllers\AbstractCRUDController;
use WezomCms\Faq\Http\Requests\Admin\FaqGroupRequest;
use WezomCms\Faq\Models\FaqGroup;

class FaqGroupsController extends AbstractCRUDController
{
    /**
     * Model name.
     *
     * @var string
     */
    protected $model = FaqGroup::class;

    /**
     * Base view path name.
     *
     * @var string
     */
    protected $view = 'cms-faq::admin.groups';

    /**
     * Resource route name.
     *
     * @var string
     */
    protected $routeName = 'admin.faq-groups';

    /**
     * Form request class name.
     *
     * @var string
     */
    protected $request = FaqGroupRequest::class;

    /**
     * Resource name for breadcrumbs and title.
     *
     * @return string
     */
    protected function title(): string
    {
        return __('cms-faq::admin.Groups');
    }

    /**
     * @return string|null
     */
    protected function frontUrl(): ?string
    {
        return route('faq');
    }

    /**
     * @param  Builder  $query
     * @param  Request  $request
     */
    protected function selectionIndexResult($query, Request $request)
    {
        $query->sorting();
    }
}
