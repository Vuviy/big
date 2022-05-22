<?php

namespace WezomCms\About\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use WezomCms\About\Models\AboutEvent;
use WezomCms\Core\Http\Controllers\AbstractCRUDController;
use WezomCms\Core\Settings\AdminLimit;
use WezomCms\Core\Settings\Fields\AbstractField;
use WezomCms\Core\Settings\MultilingualGroup;
use WezomCms\Core\Traits\SettingControllerTrait;
use WezomCms\About\Http\Requests\Admin\AboutEventRequest;

class AboutEventsController extends AbstractCRUDController
{
    use SettingControllerTrait;

    /**
     * Model name.
     *
     * @var string
     */
    protected $model = AboutEvent::class;

    /**
     * Base view path name.
     *
     * @var string
     */
    protected $view = 'cms-about::admin.events';

    /**
     * Resource route name.
     *
     * @var string
     */

    protected $routeName = 'admin.about-events';

    /**
     * Form request class name.
     *
     * @var string
     */
    protected $request = AboutEventRequest::class;

    /**
     * Resource name for breadcrumbs and title.
     *
     * @return string
     */
    protected function title(): string
    {
        return __('cms-about::admin.Events');
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
