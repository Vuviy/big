<?php

namespace WezomCms\Orders\Http\Livewire;

use Artesaos\SEOTools\Traits\SEOTools;
use Auth;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Throwable;
use WezomCms\Core\Foundation\JsResponse;
use WezomCms\Core\Rules\PhoneMask;
use WezomCms\Core\Services\CheckForSpam;
use WezomCms\Orders\Cart\Adapters\CheckoutAdapter;
use WezomCms\Orders\Contracts\CartInterface;
use WezomCms\Orders\Contracts\CartItemInterface;
use WezomCms\Orders\Contracts\DeliveryDriverInterface;
use WezomCms\Orders\Contracts\Payment\HasCheckoutFieldsInterface;
use WezomCms\Orders\Events\CreatedOrder;
use WezomCms\Orders\Models\Delivery;
use WezomCms\Orders\Models\Order;
use WezomCms\Orders\Models\OrderDeliveryInformation;
use WezomCms\Orders\Models\OrderItem;
use WezomCms\Orders\Models\OrderPaymentInformation;
use WezomCms\Orders\Models\OrderStatus;
use WezomCms\Orders\Models\Payment;
use WezomCms\Orders\Traits\CourierCheckoutTrait;
use WezomCms\Users\Models\User;

/**
 * Class Checkout
 * @package WezomCms\Orders\Http\Livewire
 * @property-read $allDeliveries
 * @property Delivery|null $delivery
 * @property-read $groupedPayments
 */
class Checkout extends Component
{
    use CourierCheckoutTrait;
    use SEOTools;

    /**
     * User information.
     *
     * @var null[]
     */
    public $user = [
        'name' => null,
        'surname' => null,
        'phone' => null,
        'email' => null,
        'communications' => null,
        'password' => null,
        'password_confirmation' => null,
        'registerMe' => null,
    ];

    /**
     * @var int|null
     */
    public $deliveryId;

    /**
     * Array for storing delivery driver fields.
     *
     * @var array
     */
    public $deliveryData = [];

    /**
     * @var int|null
     */
    public $paymentId;

    /**
     * Array for storing payment driver fields.
     *
     * @var array
     */
    public $paymentData = [];

    /**
     * @var string|null
     */
    public $comment;

    /**
     * @var string[]
     */
    protected $listeners = ['cartUpdated' => 'cartUpdated', '$refresh'];

    public function mount()
    {
        if ($driver = array_get(session('checkout-payment', []), 'driver')) {
            $this->paymentId = Payment::published()->firstWhere('driver', $driver)->id ?? null;
        }

        /** @var User $user */
        $user = optional(Auth::user());

        $this->user['name'] = $user->name;
        $this->user['surname'] = $user->surname;
        $this->user['phone'] = $user->masked_phone;
        $this->user['email'] = $user->email;
        $this->user['communications'] = $user->communications;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function render()
    {
        $cart = app(CartInterface::class);

        if ($cart->isEmpty() && null === $this->redirectTo) {
            $this->redirectRoute('checkout');
            return '<div></div>';
        }

        if ($last = $cart->content()->last()) {
            $backUrl = $last->getPurchaseItem()->getFrontUrl();
        } else {
            $backUrl = route('catalog');
        }

        $deliveries = Delivery::published()->sorting()->get();
        $payments = Payment::published()->sorting()->get();
        $communications = User::communicationTypes();

        $cartData = (new CheckoutAdapter($cart))->adapt();

        $deliveryCost = optional($this->getDeliveryDriver())->deliveryCostForCheckout($this->deliveryData);
        if ($deliveryCost) {
            $cartData['total'] += $deliveryCost;
        }

        $this->seo()->setPageName(__('cms-orders::site.checkout.Checkout'));

        return view('cms-orders::site.livewire.checkout', [
            'backUrl' => $backUrl,
            'cart' => $cartData,
            'deliveries' => $deliveries,
            'delivery' => $this->delivery,
            'payments' => $payments,
            'communications' => $communications,
            'addresses' => Auth::check() ? Auth::user()->addresses() : collect(),
            'deliveryCost' => $deliveryCost,
            'hasUnavailableProducts' => $cart->content()->filter(function (CartItemInterface $cartItem) {
                return !$cartItem->getPurchaseItem()->availableForPurchase();
            })->isNotEmpty(),
        ]);
    }

    /**
     * Form submit handler
     * @param  CheckForSpam  $checkForSpam
     * @param  CartInterface  $cart
     */
    public function send(CheckForSpam $checkForSpam, CartInterface $cart)
    {
        if (!$checkForSpam->checkInComponent($this, $this->user['email'])) {
            return;
        }

        if ($cart->isEmpty()) {
            return;
        }

        if (!$this->validateEmail()) {
            return;
        }

        $validatedData = $this->validate(...$this->rules());

        if (Auth::guest() && $this->user['registerMe'] && $this->tryRegisterUser() !== true) {
            return;
        }

        if ($order = $this->createOrder($validatedData)) {
            session()->put('order-id', $order->id);

            // Redirect to payment link or thanks page
            if ($paymentUrl = $order->getOnlinePaymentUrl()) {
                $this->redirect($paymentUrl);

                return;
            }

            $this->redirect($order->thanksPageUrl());
        }
    }

    /**
     * @param $property
     */
    public function updated($property)
    {
        if ($property === 'user.email') {
            $this->validateEmail();
            return;
        }

        call_user_func([$this, 'validateOnly'], $property, ... $this->rules());
    }

    protected function tryRegisterUser()
    {
        $userInfo = $this->user;
        $userInfo['phone'] = remove_phone_mask($userInfo['phone']);

        try {
            $user = User::create([
                'name' => $userInfo['name'],
                'surname' => $userInfo['surname'],
                'email' => $userInfo['email'],
                'phone' => $userInfo['phone'],
                'registered_through' => User::EMAIL,
                'active' => true,
                'password' => Hash::make($userInfo['password']),
            ]);

            $user->markEmailAsVerified();

            Auth::guard()->login($user);
        } catch (\Throwable $e) {
            logger(__CLASS__ . __METHOD__, ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);

            return false;
        }

        return true;
    }

    protected function validateEmail()
    {
        $this->resetErrorBag();

        $userInfo = $this->user;
        $userInfo['email_auth'] = $userInfo['email'];

        $emailUniqueRule = Rule::unique('users', 'email');

        if (Auth::check()) {
            $emailUniqueRule->ignore(Auth::user()->email, 'email');
        }

        $validator = \Validator::make(
            $userInfo,
            [
                'email' => [
                    'required',
                    'string',
                    'email:filter',
                    'max:100',
                ],
                'email_auth' => [
                    'nullable',
                    $emailUniqueRule,
                ],
            ],
            [],
            [
                'email' => __('cms-orders::site.auth.Email'),
            ]
        );

        if ($validator->fails()) {
            foreach ($validator->messages()->messages() as $field => $messages) {
                $this->addError("user.{$field}", Arr::first($messages));
            }
            return false;
        }

        return true;
    }

    /**
     * @param  int  $deliveryId
     */
    public function updatingDeliveryId(int $deliveryId)
    {
        $allDeliveries = $this->allDeliveries;

        /** @var Delivery $deliveryVariant */
        if ($deliveryVariant = $allDeliveries->get($deliveryId)) {
            /** @var DeliveryDriverInterface|null $driver */
            if ($driver = $deliveryVariant->makeDriver()) {
                $this->deliveryData = $driver->getFormInputs();
            } else {
                $this->deliveryData = array_fill_keys(['city', 'street', 'house', 'room'], '');
            }
        }
    }

    public function cartUpdated()
    {
        $this->reset('paymentId');
    }

    /**
     * @return array
     */
    protected function rules(): array
    {
        $rules = [
            // User
            'user.name' => 'required|string|max:100',
            'user.surname' => 'required|string|max:100',
            'user.phone' => ['required', 'string', new PhoneMask()],
            'user.communications' => 'nullable|array',
            'user.communications.*' => 'exists:communications,driver',
            'user.registerMe' => 'nullable|bool',
            'user.password' => [
                'nullable',
                'string',
                'min:' . config('cms.users.users.password_min_length'),
                'max:30',
                'required_if:user.registerMe,1'
            ],
            'user.password_confirmation' => ['nullable', 'string', 'required_if:user.registerMe,1', 'same:user.password'],

            'deliveryId' => 'required|exists:deliveries,id,published,1',
            'paymentId' => 'required|exists:payments,id,published,1',
            'comment' =>  'nullable|string|max:10000'
        ];

        $messages = [
            'required_if' => __('cms-core::site.layout.The attribute field is required'),
        ];

        $attributes = [
            // User
            'user.name' => __('cms-orders::site.checkout.Name'),
            'user.surname' => __('cms-orders::site.checkout.Surname'),
            'user.phone' => __('cms-orders::site.checkout.Phone'),
            'user.communications' => __('cms-orders::site.communication.Convenient way of communication'),
            'user.registerMe' => __('cms-orders::site.auth.Register me'),
            'user.password' => __('cms-orders::site.auth.Password'),
            'user.password_confirmation' => __('cms-orders::site.auth.Confirm password'),

            'deliveryId' => __('cms-orders::site.checkout.Delivery'),
            'paymentId' => __('cms-orders::site.checkout.Payment'),
            'comment' => __('cms-orders::site.checkout.Comment on the order'),
        ];

        // Add delivery rules
        $delivery = Delivery::published()->find($this->deliveryId);
        if ($delivery && $driver = $delivery->makeDriver($this->only(['deliveryData']))) {
            [$dataRules, $dataMessages, $dataAttributes] = $driver->getValidationRules();

            $rules = array_merge($rules, $this->addPrefixToKeys('deliveryData', $dataRules));
            $messages = array_merge($messages, $this->addPrefixToKeys('deliveryData', $dataMessages));
            $attributes = array_merge($attributes, $this->addPrefixToKeys('deliveryData', $dataAttributes));
        }

        // Add payment rules
        if ($payment = Payment::published()->find($this->paymentId)) {
            $paymentDriver = $driver = $payment->makeDriver();

            if ($paymentDriver instanceof HasCheckoutFieldsInterface) {
                [$dataRules, $dataMessages, $dataAttributes] = $driver->getValidationRules();

                $rules = array_merge($rules, $this->addPrefixToKeys('paymentData', $dataRules));
                $messages = array_merge($messages, $this->addPrefixToKeys('paymentData', $dataMessages));
                $attributes = array_merge($attributes, $this->addPrefixToKeys('paymentData', $dataAttributes));
            }
        }

        return [$rules, $messages, $attributes];
    }

    /**
     * @param  array  $validatedData
     * @return Order
     */
    protected function createOrder(array $validatedData): ?Order
    {
        $cart = app(CartInterface::class);

        try {
            $order = DB::transaction(function () use ($cart, $validatedData) {
                $order = Order::create();

                // Store delivery
                if ($delivery = Delivery::published()->find($this->deliveryId)) {
                    $order->delivery()->associate($delivery);

                    /** @var OrderDeliveryInformation $deliveryInformation */
                    $deliveryInformation = $order->deliveryInformation()->make();

                    if ($driver = $delivery->makeDriver($this->only(['deliveryData']))) {
                        $this->deliveryData['delivery_cost'] = $driver->deliveryCostForCheckout($this->deliveryData);
                        $driver->fillStorage($deliveryInformation, $this->deliveryData);
                    }

                    $deliveryInformation->save();
                }

                // Store payment
                if ($payment = Payment::published()->find($this->paymentId)) {
                    $order->payment()->associate($payment);

                    /** @var OrderPaymentInformation $paymentInformation */
                    $paymentInformation = $order->paymentInformation()->make();

                    $paymentDriver = $payment->makeDriver();

                    if ($paymentDriver instanceof HasCheckoutFieldsInterface) {
                        $paymentDriver->fillStorage($paymentInformation, $this->paymentData);
                    }

                    $paymentInformation->save();
                }

                // User
                if (Auth::check()) {
                    $order->user()->associate(Auth::user());
                }

                $order->client()->create([
                    'name' => $this->user['name'],
                    'surname' => $this->user['surname'],
                    'email' => $this->user['email'],
                    'phone' => remove_phone_mask($this->user['phone']),
                    'communications' => $this->user['communications'],
                    'comment' => $this->comment,
                ]);

                // Set order status as new.
                $order->changeStatus(OrderStatus::newStatus());

                // Save order
                $order->save();

                // Save cart content
                foreach ($cart->content() as $cartItem) {
                    $product = $cartItem->getPurchaseItem();

                    /** @var OrderItem $orderItem */
                    $orderItem = $order->items()->create([
                        'product_id' => $product->id,
                        'product_sale' => $product->sale,
                        'product_cost' => $product->cost,
                        'product_old_cost' => $product->old_cost,
                        'quantity' => $cartItem->getQuantity(),
                        'price' => $cartItem->getOriginalProductPrice(),
                        'purchase_price' => $cartItem->getProductPurchasePrice(),
                    ]);

                    $orderItem->save();
                }

                if (method_exists($this, 'afterCreationOrder')) {
                    call_user_func([$this, 'afterCreationOrder'], $order);
                }

                $order->save();

                $order->fresh();

                event(new CreatedOrder($order));

                return $order;
            }, 3);

            // Clear cart
            $cart->clear();

            $this->reset();

            return $order;
        } catch (Throwable $e) {
            logger('Order creation error', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);

            JsResponse::make()
                ->notification(
                    __('cms-orders::site.checkout.Order creation error Please try later'),
                    'error',
                    20
                )->emit($this);

            $this->emitSelf('$refresh');

            return null;
        }
    }

    /**
     * @return Delivery|null
     */
    public function getDeliveryProperty(): ?Delivery
    {
        return $this->deliveryId ? Delivery::published()->find($this->deliveryId) : null;
    }

    /**
     * @return DeliveryDriverInterface|null
     */
    protected function getDeliveryDriver(): ?DeliveryDriverInterface
    {
        return $this->delivery ? $this->delivery->makeDriver($this->only(['deliveryData'])) : null;
    }

    /**
     * @return \Illuminate\Support\Collection|Delivery[]
     */
    public function getAllDeliveriesProperty()
    {
        return Delivery::published()
            ->sorting()
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->id => $item];
            });
    }

    /**
     * @param  string  $prefix
     * @param  array  $items
     * @return array
     */
    protected function addPrefixToKeys(string $prefix, array $items): array
    {
        $result = [];
        foreach ($items as $key => $value) {
            $result["$prefix.$key"] = $value;
        }
        return $result;
    }
}
