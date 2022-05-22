<?php

namespace WezomCms\Localities\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use WezomCms\Localities\Models\City;
use WezomCms\Core\Http\Controllers\AbstractCRUDController;
use WezomCms\Localities\Http\Requests\Admin\LocalityRequest;
use WezomCms\Localities\Models\Locality;
use WezomCms\Orders\Models\OrderDeliveryInformation;

class LocalityController extends AbstractCRUDController
{
    /**
     * Model name.
     *
     * @var string
     */
    protected $model = Locality::class;

    /**
     * Base view path name.
     *
     * @var string
     */
    protected $view = 'cms-localities::admin.localities';

    /**
     * Resource route name.
     *
     * @var string
     */
    protected $routeName = 'admin.localities';

    /**
     * Form request class name.
     *
     * @var string
     */
    protected $request = LocalityRequest::class;

    /**
     * Resource name for breadcrumbs and title.
     *
     * @return string
     */
    protected function title(): string
    {
        return __('cms-localities::admin.Localities');
    }

    /**
     * @param  Builder|Locality  $query
     * @param  Request  $request
     */
    protected function selectionIndexResult($query, Request $request)
    {
        $query->with('city')->sorting();
    }

    /**
     * @param  Locality  $obj
     * @param  array  $viewData
     * @return array
     */
    public function formData(Locality $obj, array $viewData)
    {
        return [
            'cities' => City::getForSelect(),
        ];
    }
    /**
     * @param  Locality  $obj
     * @param  FormRequest  $request
     * @return array
     */
    protected function fill($obj, FormRequest $request): array
    {
        $obj->city()->associate($request->input('city_id'));

        return parent::fill($obj, $request);
    }

    /**
     * @param $obj
     * @param  bool  $force
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function beforeDelete($obj, bool $force = false)
    {
        if (OrderDeliveryInformation::where('locality_id', $obj->id)->exists()) {
            flash(__('cms-localities::admin.You cannot delete this item because there is an order with this shipping locality'), 'error');

            return redirect()->back();
        }
    }
}
