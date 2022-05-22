<?php

namespace WezomCms\Benefits\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use WezomCms\Benefits\Enums\BenefitsTypes;
use WezomCms\Benefits\Http\Requests\Admin\BenefitsRequest;
use WezomCms\Benefits\Models\Benefits;
use WezomCms\Core\Foundation\Helpers;
use WezomCms\Core\Http\Controllers\AbstractCRUDController;

class BenefitsController extends AbstractCRUDController
{
	/**
	 * Model name.
	 *
	 * @var string
	 */
	protected $model = Benefits::class;

	/**
	 * Indicates whether to use pagination.
	 *
	 * @var bool
	 */
	protected $paginate = false;

	/**
	 * Base view path name.
	 *
	 * @var string
	 */
	protected $view = 'cms-benefits::admin.benefits';

	/**
	 * Resource route name.
	 *
	 * @var string
	 */
	protected $routeName = 'admin.benefits';

	/**
	 * Form request class name.
	 *
	 * @var string
	 */
	protected $request = BenefitsRequest::class;

	/**
	 * Resource name for breadcrumbs and title.
	 *
	 * @return string
	 */
	protected function title(): string
	{
		return __('cms-benefits::admin.Benefits');
	}

	/**
	 * @param  Builder  $query
	 * @param  Request  $request
	 */
	protected function selectionIndexResult($query, Request $request)
	{
		$query->orderBy('sort');
	}

    /**
     * @param $result
     * @param  array  $viewData
     * @return array
     */
    protected function indexViewData($result, array $viewData): array
    {
        $result = Helpers::groupByParentId($result, 'type');

        $data = [];
        foreach ($result as $group => $items) {
            $data[$group] = Helpers::groupByParentId($items);
        }

        return ['types' => BenefitsTypes::asSelectArray(), 'result' => $data];
    }

    /**
     * @param  BenefitsTypes  $obj
     * @param  array  $viewData
     * @return array
     */
    protected function createViewData($obj, array $viewData): array
    {
        $types = BenefitsTypes::asSelectArray();

        $types = ['' => __('cms-core::admin.layout.Not set')] + $types;

        return compact('types');
    }

    /**
     * @param  BenefitsTypes  $obj
     * @param  array  $viewData
     * @return array
     */
    protected function editViewData($obj, array $viewData): array
    {
        $types = BenefitsTypes::asSelectArray();

        $types = ['' => __('cms-core::admin.layout.Not set')] + $types;

        return compact('types');
    }
}

