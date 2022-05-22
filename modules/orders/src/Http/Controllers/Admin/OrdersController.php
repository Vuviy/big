<?php

namespace WezomCms\Orders\Http\Controllers\Admin;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use WezomCms\Catalog\Models\Category;
use WezomCms\Catalog\Models\Product;
use WezomCms\Core\Contracts\ButtonInterface;
use WezomCms\Core\Contracts\ButtonsContainerInterface;
use WezomCms\Core\Foundation\Buttons\ButtonsMaker;
use WezomCms\Core\Foundation\Helpers;
use WezomCms\Core\Http\Controllers\AbstractCRUDController;
use WezomCms\Core\Settings\AdminLimit;
use WezomCms\Core\Settings\Fields\AbstractField;
use WezomCms\Core\Settings\MultilingualGroup;
use WezomCms\Core\Settings\PageName;
use WezomCms\Core\Settings\RenderSettings;
use WezomCms\Core\Settings\SiteLimit;
use WezomCms\Core\Settings\Tab;
use WezomCms\Core\Traits\ActionShowTrait;
use WezomCms\Core\Traits\Model\Filterable;
use WezomCms\Core\Traits\SettingControllerTrait;
use WezomCms\Core\Traits\SoftDeletesActionsTrait;
use WezomCms\Orders\Contracts\Payment\HasCheckoutFieldsInterface;
use WezomCms\Orders\Enums\PayedModes;
use WezomCms\Orders\Events\CreatedOrder;
use WezomCms\Orders\Http\Requests\Admin\AddOrderItemRequest;
use WezomCms\Orders\Http\Requests\Admin\CreateOrderRequest;
use WezomCms\Orders\Http\Requests\Admin\UpdateOrderRequest;
use WezomCms\Orders\ModelFilters\OrderTrashedFilter;
use WezomCms\Orders\Models\Delivery;
use WezomCms\Orders\Models\Order;
use WezomCms\Orders\Models\OrderDeliveryInformation;
use WezomCms\Orders\Models\OrderPaymentInformation;
use WezomCms\Orders\Models\OrderStatus;
use WezomCms\Orders\Models\Payment;
use WezomCms\Users\Models\User;
use WezomCms\Users\UsersServiceProvider;

class OrdersController extends AbstractCRUDController
{
    use ActionShowTrait;
    use SettingControllerTrait;
    use SoftDeletesActionsTrait;

    /**
     * Model name.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Base view path name.
     *
     * @var string
     */
    protected $view = 'cms-orders::admin.orders';

    /**
     * Resource route name.
     *
     * @var string
     */
    protected $routeName = 'admin.orders';

    /**
     * Form request class name for "create" action.
     *
     * @var string
     */
    protected $createRequest = CreateOrderRequest::class;

    /**
     * Form request class name for "update" action.
     *
     * @var string
     */
    protected $updateRequest = UpdateOrderRequest::class;

    /**
     * Resource name for breadcrumbs and title.
     *
     * @return string
     */
    protected function title(): string
    {
        return __('cms-orders::admin.orders.Orders');
    }

    /**
     * @param  Model|Order  $model
     * @return string
     */
    protected function showTitle(Model $model): string
    {
        return __(
            'cms-orders::admin.orders.Order: :number from: :date',
            ['number' => $model->id, 'date' => $model->created_at->format('d.m.Y H:i')]
        );
    }

    /**
     * @return string|object|Filterable|null
     */
    protected function trashedFilter()
    {
        return OrderTrashedFilter::class;
    }

    /**
     * @param  Order  $obj
     * @param  array  $viewData
     * @return array
     */
    protected function createViewData($obj, array $viewData): array
    {
        return [
            'deliveries' => Delivery::getForSelect(true),
            'deliveryForm' => '',
            'paymentForm' => '',
            'payments' => Payment::getForSelect(),
            'statuses' => OrderStatus::getForSelect(),
            'users' => [],
            'communicationTypes' => User::communicationTypes(),
        ];
    }

    /**
     * @param  Order  $obj
     * @param  array  $viewData
     * @return array
     */
    protected function editViewData($obj, array $viewData): array
    {
        $obj->load(['items.product' => function ($query) {
            $query->withTrashed();
        }]);

        $data = $this->createViewData($obj, $viewData);

        // Restore users select
        $users = ['' => __('cms-core::admin.layout.Not set')];
        if ($obj->user) {
            $users[$obj->user->id] = $obj->user->full_name;
        }

        $data['users'] = $users;
        $data['deliveryForm'] = $this->renderDeliveryFormInputs($obj->delivery, $obj->deliveryInformation);
        $data['paymentForm'] = $this->renderPaymentFormInputs($obj->payment, $obj->paymentInformation, $obj);

        return $data;
    }

    /**
     * @param  Model|Order  $obj
     * @param  FormRequest  $request
     * @return array
     */
    protected function fillStoreData($obj, FormRequest $request): array
    {
        $obj->payment()->associate($request->get('payment_id'));
        $obj->payed = $request->boolean('payed');
        $obj->payed_mode = PayedModes::MANUAL;

        $obj->delivery()->associate($request->get('delivery_id'));

        if (Helpers::providerLoaded(UsersServiceProvider::class)) {
            $obj->user()->associate($request->get('user_id'));
        }

        return parent::fillStoreData($obj, $request);
    }

    /**
     * @param  Order  $obj
     * @param  FormRequest  $request
     */
    protected function afterSuccessfulStore($obj, FormRequest $request)
    {
        $obj->changeStatus(OrderStatus::find($request->get('status_id')))->save();

        $obj->client()->create($request->get('client', []));

        $obj->deliveryInformation()->create($request->get('deliveryInformation', []));

        $obj->paymentInformation()->create($request->get('paymentInformation', []));
    }

    /**
     * @param  Order  $obj
     * @param  FormRequest  $request
     * @return array
     */
    protected function fillUpdateData($obj, FormRequest $request): array
    {
        $obj->changeStatus(OrderStatus::find($request->get('status_id')));

        $obj->payment()->associate($request->get('payment_id'));
        $obj->payed = $request->get('payed');

        // If manually changed payed status
        if ($obj->isDirty('payed')) {
            $obj->payed_mode = PayedModes::MANUAL;
        }

        $obj->delivery()->associate($request->get('delivery_id'));

        if (Helpers::providerLoaded(UsersServiceProvider::class)) {
            $obj->user()->associate($request->get('user_id'));
        }

        return parent::fillUpdateData($obj, $request);
    }

    /**
     * @param  Order  $obj
     * @param  FormRequest  $request
     */
    public function afterSuccessfulUpdate($obj, FormRequest $request)
    {
        foreach ($request->get('QUANTITY', []) as $id => $quantity) {
            $obj->items()->whereKey($id)->update(compact('quantity'));
        }

        $obj->client()->updateOrCreate([], $request->get('client', []));

        $obj->deliveryInformation()->updateOrCreate([], $request->get('deliveryInformation', []));

        $obj->paymentInformation()->updateOrCreate([], $request->get('paymentInformation', []));
    }

    /**
     * @param $id
     * @param  ButtonsContainerInterface  $buttonsContainer
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function addItem($id, ButtonsContainerInterface $buttonsContainer)
    {
        $order = Order::findOrFail($id);

        $this->authorizeForAction('edit', $order);

        $this->before();

        $buttonsContainer->add(ButtonsMaker::save())
            ->add(ButtonsMaker::saveAndClose(route('admin.orders.edit', $order->id)))
            ->add(ButtonsMaker::close(route('admin.orders.edit', $order->id)));

        $this->addBreadcrumb(
            __(
                'cms-orders::admin.orders.Order: :number from: :date',
                ['number' => $order->id, 'date' => $order->created_at->format('d.m.Y H:i')]
            )
        );

        $this->pageName->setPageName(__('cms-orders::admin.orders.Add item'));
        $this->addBreadcrumb(__('cms-orders::admin.orders.Add item'));
        $this->renderJsValidator(new AddOrderItemRequest());

        return view('cms-orders::admin.orders.add-item', [
            'routeName' => $this->routeName,
            'obj' => $order,
            'categoriesTree' => Category::getForSelect(),
        ]);
    }

    /**
     * @param $id
     * @param  AddOrderItemRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function storeItem($id, AddOrderItemRequest $request)
    {
        $order = Order::findOrFail($id);

        $this->authorizeForAction('edit', $order);

        $product = Product::findOrFail($request->get('product_id'));

        $order->items()->create([
            'product_id' => $request->get('product_id'),
            'quantity' => $request->get('quantity', $product->minCountForPurchase()),
            'price' => $product->priceForPurchase(),
            'purchase_price' => $product->priceForPurchase(),
        ]);

        event(new CreatedOrder($order));

        flash(__('cms-orders::admin.orders.Item successfully stored'))->success();

        // Redirect
        switch (app('request')->get('form-action')) {
            case ButtonInterface::ACTION_SAVE_AND_CLOSE:
                return redirect()->route('admin.orders.edit', $order->id);
            case ButtonInterface::ACTION_SAVE:
            default:
                if (ButtonInterface::ACTION_STORE === app(Route::class)->getActionMethod()) {
                    return redirect()->route('admin.orders.edit', [$order->id]);
                }

                return redirect()->back();
        }
    }

    /**
     * @param $id
     * @param $itemId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function deleteItem($id, $itemId)
    {
        $obj = Order::findOrFail($id);

        $this->authorizeForAction('edit', $obj);

        if ($obj->items()->where('id', $itemId)->delete()) {
            flash(__('cms-core::admin.layout.Data deleted successfully'))->success();
        } else {
            flash(__('cms-core::admin.layout.Data deletion error'))->error();
        }

        return redirect()->back();
    }

    /**
     * @param  Request  $request
     * @return mixed|string|null
     */
    public function renderDeliveryForm(Request $request)
    {
        $delivery = Delivery::find($request->input('delivery_id'));
        if (!$delivery) {
            return $this->success(['html' => '']);
        }

        $deliveryInformation = OrderDeliveryInformation::make($request->input('deliveryInformation', []));

        return $this->success([
            'html' => optional($this->renderDeliveryFormInputs($delivery, $deliveryInformation))->render()
        ]);
    }

    /**
     * @param  Request  $request
     * @param  Order|null  $order
     * @return mixed|string|null
     */
    public function renderPaymentForm(Request $request, ?Order $order = null)
    {
        $payment = Payment::find($request->input('payment_id'));
        if (!$payment) {
            return $this->success(['html' => '']);
        }

        $paymentInformation = OrderPaymentInformation::make($request->input('paymentInformation', []));

        return $this->success([
            'html' => (string)$this->renderPaymentFormInputs($payment, $paymentInformation, $order)
        ]);
    }

    /**
     * @param  Delivery  $delivery
     * @param  OrderDeliveryInformation  $deliveryInformation
     * @return View|null
     */
    protected function renderDeliveryFormInputs(Delivery $delivery, OrderDeliveryInformation $deliveryInformation)
    {
        $driver = optional($delivery)->makeDriver();
        if (!$driver) {
            return null;
        }

        return $driver->renderAdminFormInputs($deliveryInformation);
    }

    /**
     * @param  Payment  $payment
     * @param  OrderPaymentInformation  $paymentInformation
     * @param  Order|null  $order
     * @return mixed|null
     */
    protected function renderPaymentFormInputs(
        Payment $payment,
        OrderPaymentInformation $paymentInformation,
        ?Order $order = null
    ) {
        $driver = optional($payment)->makeDriver();
        if (!$driver || !$driver instanceof HasCheckoutFieldsInterface) {
            return null;
        }

        return $driver->renderAdminFormInputs($paymentInformation, $order);
    }

    /**
     * @return array|AbstractField[]|MultilingualGroup[]
     * @throws \Exception
     */
    protected function settings(): array
    {
        return [
            SiteLimit::make()->setName(__('cms-orders::admin.orders.Orders history limit at page in LK')),
            MultilingualGroup::make(RenderSettings::siteTab(), [PageName::make()->setName(__('cms-orders::admin.orders.Orders history page name at page in LK'))->default('cms-orders::admin.orders.Orders history')]),
            MultilingualGroup::make(
                new RenderSettings(
                    new Tab('site_thanks', __('cms-orders::admin.orders.Thanks page'), 2, 'fa-file-text')
                ),
                [PageName::make()->default('Thanks')]
            ),
            AdminLimit::make(),
        ];
    }

    /**
     * @param  Order  $obj
     * @param  array  $viewData
     * @return array
     */
    protected function showViewData($obj, array $viewData): array
    {
        $paymentDriver = $obj->payment ? $obj->payment->makeDriver() : null;
        $paymentData = null;

        if ($paymentDriver && is_a($paymentDriver, HasCheckoutFieldsInterface::class)) {
            $paymentData = $paymentDriver->renderAdminFormData($obj->paymentInformation, $obj);
        }

        return [
            'delivery' => optional($obj->delivery)->name,
            'deliveryData' => $obj->delivery
                ? optional($obj->delivery->makeDriver())->renderAdminFormData($obj->deliveryInformation)
                : null,
            'paymentData' => $paymentData,
            'payment' => optional($obj->payment)->name,
            'payed' => $obj->payed ? __('cms-core::admin.layout.Yes') : __('cms-core::admin.layout.No'),
            'status' => optional($obj->status)->name,
            'communicationTypes' => User::communicationTypes(),
        ];
    }
}
