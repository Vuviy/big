<?php

namespace WezomCms\Orders\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use WezomCms\Core\Http\Controllers\AbstractCRUDController;
use WezomCms\Core\Settings\Fields\AbstractField;
use WezomCms\Core\Settings\Fields\MultiInput;
use WezomCms\Core\Settings\MultilingualGroup;
use WezomCms\Core\Settings\RenderSettings;
use WezomCms\Core\Settings\Tab;
use WezomCms\Core\Traits\SettingControllerTrait;
use WezomCms\Orders\Http\Requests\Admin\DeliveryRequest;
use WezomCms\Orders\Models\Delivery;

class DeliveriesController extends AbstractCRUDController
{
    use SettingControllerTrait;

    /**
     * Model name.
     *
     * @var string
     */
    protected $model = Delivery::class;

    /**
     * Base view path name.
     *
     * @var string
     */
    protected $view = 'cms-orders::admin.deliveries';

    /**
     * Resource route name.
     *
     * @var string
     */
    protected $routeName = 'admin.deliveries';

    /**
     * Form request class name.
     *
     * @var string
     */
    protected $request = DeliveryRequest::class;

    /**
     * Resource name for breadcrumbs and title.
     *
     * @return string
     */
    protected function title(): string
    {
        return __('cms-orders::admin.deliveries.Deliveries');
    }

    /**
     * @param  Builder|Delivery  $query
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
        $result = [];

        $advantages = new RenderSettings(new Tab('advantages', __('cms-orders::admin.Advantages'), 1));

        $result[] = new MultilingualGroup($advantages, [
            MultiInput::make()
                ->setKey('advantages')
                ->setIsMultilingual()
                ->setName(__('cms-orders::admin.Advantages'))
        ]);

        return $result;
    }
}
