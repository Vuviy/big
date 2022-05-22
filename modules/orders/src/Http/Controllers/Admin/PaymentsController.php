<?php

namespace WezomCms\Orders\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use WezomCms\Core\Http\Controllers\AbstractCRUDController;
use WezomCms\Core\Settings\Fields\AbstractField;
use WezomCms\Core\Settings\Fields\Input;
use WezomCms\Core\Settings\Fields\MultiInput;
use WezomCms\Core\Settings\Fields\Radio;
use WezomCms\Core\Settings\Fields\Textarea;
use WezomCms\Core\Settings\MultilingualGroup;
use WezomCms\Core\Settings\RenderSettings;
use WezomCms\Core\Settings\Tab;
use WezomCms\Core\Traits\SettingControllerTrait;
use WezomCms\Orders\Http\Requests\Admin\PaymentRequest;
use WezomCms\Orders\Models\Payment;

class PaymentsController extends AbstractCRUDController
{
    use SettingControllerTrait;

    /**
     * Model name.
     *
     * @var string
     */
    protected $model = Payment::class;

    /**
     * Base view path name.
     *
     * @var string
     */
    protected $view = 'cms-orders::admin.payments';

    /**
     * Resource route name.
     *
     * @var string
     */
    protected $routeName = 'admin.payments';

    /**
     * Form request class name.
     *
     * @var string
     */
    protected $request = PaymentRequest::class;

    /**
     * Resource name for breadcrumbs and title.
     *
     * @return string
     */
    protected function title(): string
    {
        return __('cms-orders::admin.payments.Payments');
    }

    /**
     * @param Builder|Payment $query
     * @param Request $request
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

        $cloudPayment = new RenderSettings(new Tab('cloud-payment', __('cms-orders::admin.payments.Cloudpayments')));

        $result = [];

        $result[] = Radio::make($cloudPayment)
            ->setKey('test')
            ->setValuesList([0 => __('cms-orders::admin.payments.Off'), 1 => __('cms-orders::admin.payments.On')])
            ->setName(__('cms-orders::admin.payments.Test mode'));
        $result[] = Input::make($cloudPayment)
            ->setKey('public_id')
            ->setName(__('cms-orders::admin.payments.Public ID'))
            ->setRules('nullable|string|max:100');
        $result[] = Input::make($cloudPayment)
            ->setKey('api_secret')
            ->setName(__('cms-orders::admin.payments.API Secret'))
            ->setRules('nullable|string|max:250');

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
