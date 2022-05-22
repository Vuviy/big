<?php

namespace WezomCms\Newsletter\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use WezomCms\Core\Http\Controllers\AbstractCRUDController;
use WezomCms\Newsletter\Http\Requests\Admin\SubscribeRequest;
use WezomCms\Newsletter\Models\Subscriber;

class SubscribersController extends AbstractCRUDController
{
    /**
     * Model name.
     *
     * @var string
     */
    protected $model = Subscriber::class;

    /**
     * Base view path name.
     *
     * @var string
     */
    protected $view = 'cms-newsletter::admin.subscribers';

    /**
     * Resource route name.
     *
     * @var string
     */
    protected $routeName = 'admin.subscribers';

    /**
     * Form request class name.
     *
     * @var string
     */
    protected $request = SubscribeRequest::class;

    /**
     * Resource name for breadcrumbs and title.
     *
     * @return string
     */
    protected function title(): string
    {
        return __('cms-newsletter::admin.Subscribers');
    }

    /**
     * @param  Builder|Subscriber  $query
     * @param  Request  $request
     */
    protected function selectionIndexResult($query, Request $request)
    {
        $query->latest();
    }

    /**
     * @param  Subscriber  $obj
     * @param  array  $viewData
     * @return array
     */
    protected function formData($obj, array $viewData): array
    {
        $locales = ['' => __('cms-core::admin.layout.Not set')] + app('locales');

        return compact('locales');
    }
}
