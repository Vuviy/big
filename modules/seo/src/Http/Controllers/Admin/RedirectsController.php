<?php

namespace WezomCms\Seo\Http\Controllers\Admin;

use Gate;
use WezomCms\Core\Contracts\ButtonsContainerInterface;
use WezomCms\Core\Foundation\Buttons\Link;
use WezomCms\Core\Http\Controllers\AbstractCRUDController;
use WezomCms\Seo\Enums\RedirectHttpStatus;
use WezomCms\Seo\Http\Requests\Admin\RedirectRequest;
use WezomCms\Seo\Models\SeoRedirect;

class RedirectsController extends AbstractCRUDController
{
    /**
     * Model name.
     *
     * @var string
     */
    protected $model = SeoRedirect::class;

    /**
     * Base view path name.
     *
     * @var string
     */
    protected $view = 'cms-seo::admin.redirects';

    /**
     * Resource route name.
     *
     * @var string
     */
    protected $routeName = 'admin.seo-redirects';

    /**
     * Form request class name.
     *
     * @var string
     */
    protected $request = RedirectRequest::class;

    /**
     * Resource name for breadcrumbs and title.
     *
     * @return string
     */
    protected function title(): string
    {
        return __('cms-seo::admin.redirects.Redirects');
    }

    /**
     * @param  SeoRedirect  $obj
     * @param  array  $viewData
     * @return array
     */
    protected function formData($obj, array $viewData): array
    {
        return ['httpStatuses' => RedirectHttpStatus::asSelectArray()];
    }

    /**
     * Register index buttons.
     *
     * @return ButtonsContainerInterface
     */
    protected function indexButtons()
    {
        $buttons = parent::indexButtons();

        if (Gate::allows('seo-redirects.import')) {
            $importButton = Link::make()
                ->setName(__('cms-seo::admin.redirects.Import'))
                ->setTitle(__('cms-seo::admin.redirects.Import redirects from file'))
                ->setLink(route('admin.seo-redirects.import'))
                ->setClass('btn-sm', 'btn-info')
                ->setIcon('fa-download')
                ->setSortPosition(2);

            $buttons->add($importButton);
        }

        return $buttons;
    }
}
