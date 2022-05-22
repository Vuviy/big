<?php

namespace WezomCms\About\Http\Controllers\Admin;

use WezomCms\About\Http\Requests\Admin\AboutReviewRequest;
use WezomCms\About\Models\AboutReview;
use WezomCms\Core\Http\Controllers\AbstractCRUDController;
use WezomCms\Core\Settings\AdminLimit;
use WezomCms\Core\Settings\Fields\AbstractField;
use WezomCms\Core\Settings\MultilingualGroup;
use WezomCms\Core\Traits\SettingControllerTrait;

class AboutReviewsController extends AbstractCRUDController
{
    use SettingControllerTrait;

    /**
     * Model name.
     *
     * @var string
     */
    protected $model = AboutReview::class;

    /**
     * Base view path name.
     *
     * @var string
     */
    protected $view = 'cms-about::admin.reviews';

    /**
     * Resource route name.
     *
     * @var string
     */

    protected $routeName = 'admin.about-reviews';

    /**
     * Form request class name.
     *
     * @var string
     */
    protected $request = AboutReviewRequest::class;

    /**
     * Resource name for breadcrumbs and title.
     *
     * @return string
     */
    protected function title(): string
    {
        return __('cms-about::admin.Reviews');
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
