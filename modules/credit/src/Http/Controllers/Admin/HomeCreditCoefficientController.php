<?php

namespace WezomCms\Credit\Http\Controllers\Admin;

use Illuminate\Http\Request;
use WezomCms\Core\Http\Controllers\AbstractCRUDController;
use WezomCms\Core\Settings\Fields\AbstractField;
use WezomCms\Core\Settings\Fields\Input;
use WezomCms\Core\Settings\Fields\Radio;
use WezomCms\Core\Settings\MultilingualGroup;
use WezomCms\Core\Settings\RenderSettings;
use WezomCms\Core\Traits\SettingControllerTrait;
use WezomCms\Credit\Http\Requests\Admin\HomeCreditCoefficientRequest;
use WezomCms\Credit\Models\HomeCreditCoefficient;

class HomeCreditCoefficientController extends AbstractCRUDController
{
    use SettingControllerTrait;

    /**
     * Model name.
     *
     * @var string
     */
    protected $model = HomeCreditCoefficient::class;

    /**
     * Base view path name.
     *
     * @var string
     */
    protected $view = 'cms-credit::admin.home-credit-coefficients';

    /**
     * Resource route name.
     *
     * @var string
     */
    protected $routeName = 'admin.home-credit-coefficients';

    /**
     * Form request class name.
     *
     * @var string
     */
    protected $request = HomeCreditCoefficientRequest::class;

    /**
     * Resource name for breadcrumbs and title.
     *
     * @return string
     */
    protected function title(): string
    {
        return __('cms-credit::admin.HomeCredit coefficients');
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder|HomeCreditCoefficient  $query
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
        $rs = RenderSettings::siteTab();

        return [
            Radio::make($rs)
                ->setKey('test')
                ->setValuesList([0 => __('cms-credit::admin.Off'), 1 => __('cms-credit::admin.On')])
                ->setName(__('cms-credit::admin.Test mode')),
            Input::make($rs)
                ->setKey('partner_id')
                ->setName(__('cms-credit::admin.Partner ID'))
                ->setRules('nullable|numeric|min:0'),
            Input::make($rs)
                ->setKey('access_token')
                ->setName(__('cms-credit::admin.Access Token'))
                ->setRules('nullable|string|max:100'),
            Input::make($rs)
                ->setKey('auth_key')
                ->setName(__('cms-credit::admin.Auth key for status change'))
                ->setRules('nullable|string|max:200'),
        ];
    }

    /**
     * @return string
     */
    protected function controllerBaseName(): string
    {
        return 'home-credit';
    }
}
