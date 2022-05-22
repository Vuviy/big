<?php

namespace WezomCms\Callbacks\Http\Controllers\Admin;

use WezomCms\Callbacks\Http\Requests\Admin\CallbackRequest;
use WezomCms\Callbacks\Models\Callback;
use WezomCms\Core\Http\Controllers\AbstractCRUDController;
use WezomCms\Core\Settings\AdminLimit;
use WezomCms\Core\Traits\SettingControllerTrait;

class CallbacksController extends AbstractCRUDController
{
    use SettingControllerTrait;

    /**
     * Model name.
     *
     * @var string
     */
    protected $model = Callback::class;

    /**
     * Base view path name.
     *
     * @var string
     */
    protected $view = 'cms-callbacks::admin';

    /**
     * Resource route name.
     *
     * @var string
     */
    protected $routeName = 'admin.callbacks';

    /**
     * Form request class name.
     *
     * @var string
     */
    protected $request = CallbackRequest::class;

    /**
     * Resource name for breadcrumbs and title.
     *
     * @return string
     */
    protected function title(): string
    {
        return __('cms-callbacks::admin.Callbacks');
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function settings(): array
    {
        return [AdminLimit::make()];
    }
}
