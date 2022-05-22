<?php

namespace WezomCms\Slider\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use WezomCms\Core\Foundation\Helpers;
use WezomCms\Core\Http\Controllers\AbstractCRUDController;
use WezomCms\Slider\Http\Requests\Admin\SliderRequest;
use WezomCms\Slider\Models\Slide;

class SlideController extends AbstractCRUDController
{
    /**
     * Model name.
     *
     * @var string
     */
    protected $model = Slide::class;

    /**
     * Base view path name.
     *
     * @var string
     */
    protected $view = 'cms-slider::admin';

    /**
     * Indicates whether to use pagination.
     *
     * @var bool
     */
    protected $paginate = false;

    /**
     * Resource route name.
     *
     * @var string
     */
    protected $routeName = 'admin.slides';

    /**
     * Form request class name.
     *
     * @var string
     */
    protected $request = SliderRequest::class;

    /**
     * Resource name for breadcrumbs and title.
     *
     * @return string
     */
    protected function title(): string
    {
        return __('cms-slider::admin.Sliders');
    }

    /**
     * @param  Builder|Slide  $query
     * @param  Request  $request
     */
    protected function selectionIndexResult($query, Request $request)
    {
        $query->sorting();
    }

    /**
     * @param $result
     * @param  array  $viewData
     * @return array
     */
    protected function indexViewData($result, array $viewData): array
    {
        return [
            'result' => config('cms.slider.slider.sliders'),
            'slides' => Helpers::groupByParentId($result, 'slider')
        ];
    }

    /**
     * @param  Slide  $obj
     * @param  array  $viewData
     * @return array
     */
    protected function formData($obj, array $viewData): array
    {
        $sliders = collect(config('cms.slider.slider.sliders'))
            ->map(function ($el) {
                return __($el['name']);
            })
            ->prepend(__('cms-core::admin.layout.Not set'), '');

        return compact('sliders');
    }
}
