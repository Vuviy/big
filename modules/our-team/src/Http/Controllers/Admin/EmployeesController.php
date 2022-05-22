<?php

namespace WezomCms\OurTeam\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use WezomCms\Core\Http\Controllers\AbstractCRUDController;
use WezomCms\Core\Settings\AdminLimit;
use WezomCms\Core\Settings\Fields\AbstractField;
use WezomCms\Core\Settings\MultilingualGroup;
use WezomCms\Core\Traits\SettingControllerTrait;
use WezomCms\OurTeam\Http\Requests\Admin\EmployeeRequest;
use WezomCms\OurTeam\Models\Employee;

class EmployeesController extends AbstractCRUDController
{
    use SettingControllerTrait;

    /**
     * Model name.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Base view path name.
     *
     * @var string
     */
    protected $view = 'cms-our-team::admin';

    /**
     * Resource route name.
     *
     * @var string
     */
    protected $routeName = 'admin.employees';

    /**
     * Form request class name.
     *
     * @var string
     */
    protected $request = EmployeeRequest::class;

    /**
     * Resource name for breadcrumbs and title.
     *
     * @return string
     */
    protected function title(): string
    {
        return __('cms-our-team::admin.Our team');
    }

    /**
     * @param  Builder|Employee  $query
     * @param  Request  $request
     */
    protected function selectionIndexResult($query, Request $request)
    {
        $query->sorting();
    }

    /**
     * @return array|AbstractField[]|MultilingualGroup[]
     * @throws \Exception
     */
    protected function settings(): array
    {
        return [
            AdminLimit::make(),
        ];
    }
}
