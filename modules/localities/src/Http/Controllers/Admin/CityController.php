<?php

namespace WezomCms\Localities\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use WezomCms\Core\Http\Controllers\AbstractCRUDController;
use WezomCms\Localities\Http\Requests\Admin\CityRequest;
use WezomCms\Localities\Models\City;
use WezomCms\Localities\Models\Locality;
use WezomCms\Orders\Models\OrderDeliveryInformation;

class CityController extends AbstractCRUDController
{
    /**
     * Model name.
     *
     * @var string
     */
    protected $model = City::class;

    /**
     * Base view path name.
     *
     * @var string
     */
    protected $view = 'cms-localities::admin.cities';

    /**
     * Resource route name.
     *
     * @var string
     */
    protected $routeName = 'admin.cities';

    /**
     * Form request class name.
     *
     * @var string
     */
    protected $request = CityRequest::class;

    /**
     * Resource name for breadcrumbs and title.
     *
     * @return string
     */
    protected function title(): string
    {
        return __('cms-localities::admin.Cities');
    }

    /**
     * @param Builder $query
     * @param Request $request
     */
    protected function selectionIndexResult($query, Request $request)
    {
        $query->sorting();
    }

    /**
     * @param $obj
     * @param bool $force
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function beforeDelete($obj, bool $force = false)
    {
        if (Locality::where('city_id', $obj->id)->exists()) {
            flash(__('cms-localities::admin.You cannot delete this item because there are settlements dependent on it'), 'error');

            return redirect()->back();
        }
    }
}
