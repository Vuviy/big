<?php

namespace WezomCms\BuyOneClick\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use WezomCms\BuyOneClick\Http\Requests\Admin\BuyOneClickRequest;
use WezomCms\BuyOneClick\Models\BuyOneClick;
use WezomCms\Core\Http\Controllers\AbstractCRUDController;
use WezomCms\Core\Settings\AdminLimit;
use WezomCms\Core\Traits\SettingControllerTrait;

class BuyOneClickController extends AbstractCRUDController
{
    use SettingControllerTrait;

    /**
     * Model name.
     *
     * @var string
     */
    protected $model = BuyOneClick::class;

    /**
     * Base view path name.
     *
     * @var string
     */
    protected $view = 'cms-buy-one-click::admin';

    /**
     * Resource route name.
     *
     * @var string
     */
    protected $routeName = 'admin.buy-one-click';

    /**
     * Form request class name.
     *
     * @var string
     */
    protected $request = BuyOneClickRequest::class;

    /**
     * Resource name for breadcrumbs and title.
     *
     * @return string
     */
    protected function title(): string
    {
        return __('cms-buy-one-click::admin.Buy one click');
    }

    /**
     * @param  Builder|BuyOneClick  $query
     * @param  Request  $request
     */
    protected function selectionIndexResult($query, Request $request)
    {
        $query->with(['product' => function ($query) {
            $query->withTrashed();
        }]);
    }

    /**
     * @param  BuyOneClick  $obj
     * @param  array  $viewData
     * @return array
     */
    protected function editViewData($obj, array $viewData): array
    {
        $obj->load(['product' => function ($query) {
            $query->withTrashed();
        }]);

        return [];
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
