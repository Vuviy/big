<?php

namespace WezomCms\Users\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use WezomCms\Core\Http\Controllers\AbstractCRUDController;
use WezomCms\Users\Http\Requests\Admin\UserAddressRequest;
use WezomCms\Orders\Models\UserAddress;

class UserAddressController extends AbstractCRUDController
{
    /**
     * Model name.
     *
     * @var string
     */
    protected $model = UserAddress::class;

    /**
     * Base view path name.
     *
     * @var string
     */
    protected $view = 'cms-users::admin.user-addresses';

    /**
     * Resource route name.
     *
     * @var string
     */
    protected $routeName = 'admin.user-addresses';

    /**
     * Form request class name.
     *
     * @var string
     */
    protected $request = UserAddressRequest::class;

    /**
     * @param $obj
     * @param array $viewData
     * @return array[]
     */
    public function createViewData($obj, array $viewData): array
    {
        return [
            'users' => [],
        ];
    }

    /**
     * @param $obj
     * @param array $viewData
     * @return array[]
     */
    public function editViewData($obj, array $viewData): array
    {
        return [
            'users' => $obj->user ? [$obj->user->id => $obj->user->full_name] : [],
        ];
    }


    protected function title(): string
    {
        return __('cms-users::admin.Адреса');
    }

    /**
     * @param Builder $query
     * @param Request $request
     */
    protected function selectionIndexResult($query, Request $request)
    {
//        $query->with(['user' => function ($query) {
//            $query->withTrashed();
//        }]);
    }

    /**
     * @param Model|UserAddress $obj
     */
    protected function fill($obj, FormRequest $request): array
    {

        $obj->user()->associate($request->get('user_id'));

        return parent::fill($obj, $request);
    }

    /**
     * @param UserAddress $obj
     * @param FormRequest $request
     */
    protected function afterSuccessfulSave($obj, FormRequest $request)
    {
        if ($obj->primary) {
            $obj->user->addresses()->where('id', '!=', $obj->id)->update(['primary' => false]);
        }
    }
}
