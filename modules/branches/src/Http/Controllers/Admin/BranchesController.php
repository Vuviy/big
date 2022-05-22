<?php

namespace WezomCms\Branches\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use WezomCms\Branches\Http\Requests\Admin\BranchRequest;
use WezomCms\Branches\Models\Branch;
use WezomCms\Core\Http\Controllers\AbstractCRUDController;
use WezomCms\Core\Settings\AdminLimit;
use WezomCms\Core\Settings\Fields\AbstractField;
use WezomCms\Core\Settings\MultilingualGroup;
use WezomCms\Core\Traits\SettingControllerTrait;

class BranchesController extends AbstractCRUDController
{
    use SettingControllerTrait;

    /**
     * Model name.
     *
     * @var string
     */
    protected $model = Branch::class;

    /**
     * Base view path name.
     *
     * @var string
     */
    protected $view = 'cms-branches::admin';

    /**
     * Resource route name.
     *
     * @var string
     */

    protected $routeName = 'admin.branches';

    /**
     * Form request class name.
     *
     * @var string
     */
    protected $request = BranchRequest::class;

    /**
     * Resource name for breadcrumbs and title.
     *
     * @return string
     */
    protected function title(): string
    {
        return __('cms-branches::admin.Branches');
    }

    /**
     * @param  Builder|Branch  $query
     * @param  Request  $request
     */
    protected function selectionIndexResult($query, Request $request)
    {
        $query->sorting();
    }

    /**
     * @param  Branch  $obj
     * @param  FormRequest  $request
     * @return array
     */
    protected function fill($obj, FormRequest $request): array
    {
        $data = parent::fill($obj, $request);

        $data['phones'] = array_filter($request->get('phones', []));
        $data['map'] = (array)json_decode($request->get('map'));

        return $data;
    }

    /**
     * @return array|AbstractField[]|MultilingualGroup[]
     * @throws \Exception
     */
    protected function settings(): array
    {
        return [AdminLimit::make()];
    }
}
