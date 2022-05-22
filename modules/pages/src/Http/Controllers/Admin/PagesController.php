<?php

namespace WezomCms\Pages\Http\Controllers\Admin;

use WezomCms\Core\Http\Controllers\AbstractCRUDController;
use WezomCms\Core\Settings\AdminLimit;
use WezomCms\Core\Traits\SettingControllerTrait;
use WezomCms\Pages\Http\Requests\Admin\PageRequest;
use WezomCms\Pages\Models\Page;

class PagesController extends AbstractCRUDController
{
    use SettingControllerTrait;

    /**
     * Model name.
     *
     * @var string
     */
    protected $model = Page::class;

    /**
     * Base view path name.
     *
     * @var string
     */
    protected $view = 'cms-pages::admin';

    /**
     * Resource route name.
     *
     * @var string
     */
    protected $routeName = 'admin.pages';

    /**
     * Form request class name.
     *
     * @var string
     */
    protected $request = PageRequest::class;

    /**
     * Resource name for breadcrumbs and title.
     *
     * @return string
     */
    protected function title(): string
    {
        return __('cms-pages::admin.Pages');
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
