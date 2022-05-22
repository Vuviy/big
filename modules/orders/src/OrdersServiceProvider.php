<?php

namespace WezomCms\Orders;

use Auth;
use Cart;
use Event;
use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;
use SidebarMenu;
use WezomCms\Catalog\Models\Product;
use WezomCms\Core\BaseServiceProvider;
use WezomCms\Core\Contracts\Assets\AssetManagerInterface;
use WezomCms\Core\Contracts\PermissionsContainerInterface;
use WezomCms\Core\Foundation\Helpers;
use WezomCms\Core\Models\Administrator;
use WezomCms\Orders\Cart\Storage\DatabaseStorage;
use WezomCms\Orders\Cart\Storage\SessionStorage;
use WezomCms\Orders\Contracts\CartInterface;
use WezomCms\Orders\Contracts\NeedClearOldHashesInterface;
use WezomCms\Orders\Database\Seeders\CommunicationsSeeder;
use WezomCms\Orders\Database\Seeders\DeliveriesSeeder;
use WezomCms\Orders\Database\Seeders\OrderStatusesSeeder;
use WezomCms\Orders\Database\Seeders\PaymentsSeeder;
use WezomCms\Orders\Enums\PayedModes;
use WezomCms\Orders\Events\AutoPayedOrder;
use WezomCms\Orders\Events\CreatedOrder;
use WezomCms\Orders\Listeners\SendAutoPayedOrderNotification;
use WezomCms\Orders\Listeners\SendCreatedOrderNotification;
use WezomCms\Orders\Models\Communication;
use WezomCms\Orders\Models\Delivery;
use WezomCms\Orders\Models\Order;
use WezomCms\Orders\Models\OrderItem;
use WezomCms\Orders\Models\OrderStatus;
use WezomCms\Orders\Models\Payment;
use WezomCms\Orders\Models\UserAddress;
use WezomCms\Orders\Observers\OrderObserver;
use WezomCms\ProductReviews\Models\ProductReview;
use WezomCms\Users\Models\User;
use WezomCms\Users\UsersServiceProvider;

class OrdersServiceProvider extends BaseServiceProvider
{
    /**
     * All module widgets.
     *
     * @var array|string|null
     */
    protected $widgets = 'cms.orders.orders.widgets';

    /**
     * Dashboard widgets.
     *
     * @var array|string|null
     */
    protected $dashboard = 'cms.orders.orders.dashboards';

    /**
     * List of enum classes for auto scanning localization keys.
     *
     * @var array
     */
    protected $enumClasses = [
        PayedModes::class,
    ];

    /**
     * Custom translation keys.
     *
     * @var array
     */
    protected $translationKeys = [
        'cms-orders::admin.pieces',
        'cms-orders::site.pieces',
        'cms-orders::admin.house',
        'cms-orders::site.house',
        'cms-orders::admin.room',
        'cms-orders::site.room',
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CartInterface::class, function () {
            $precision = config('cms.core.money.precision', 0);
            $quantityPrecision = config('cms.orders.cart.quantity_precision', 0);
            $driver = config('cms.orders.cart.storage');

            switch ($driver) {
                case 'database':
                    return new DatabaseStorage($precision, $quantityPrecision);
                case 'session':
                    return new SessionStorage($precision, $quantityPrecision);
                default:
                    throw new \Exception("Unsupported cart driver '{$driver}'");
            }
        });
    }

    /**
     * Application booting.
     */
    public function boot()
    {
        Product::addExternalMethod('getInCartAttribute', function () {
            /** @var Product $this */
            return Cart::hasProduct($this->id);
        });

        if (Helpers::providerLoaded(UsersServiceProvider::class)) {
            User::addExternalMethod('addresses', function () {
                /** @var User $this */
                return $this->hasMany(UserAddress::class);
            });
        }

        parent::boot();
    }

    protected function afterBootForAdminPanel()
    {
        app(AssetManagerInterface::class)
            ->addJs('vendor/cms/orders/orders.js', 'orders')
            ->group(AssetManagerInterface::GROUP_ADMIN);
    }

    /**
     * @param  PermissionsContainerInterface  $permissions
     */
    public function permissions(PermissionsContainerInterface $permissions)
    {
        // Orders
        $permissions->add('orders', __('cms-orders::admin.orders.Orders'))
            ->withShow()
            ->withSoftDeletes()
            ->withEditSettings();

        // Statuses
        $permissions->add(
            'order-statuses',
            __('cms-orders::admin.statuses.Order statuses'),
            [
                'view',
//                'create',
                'edit',
                'edit-settings',
                'delete' => function (Administrator $administrator, OrderStatus $obj) {
                    return !in_array(
                        $obj->id,
                        [OrderStatus::NEW, OrderStatus::DONE, OrderStatus::CANCELED]
                    )
                        && $obj->orders()->doesntExist()
                        && $administrator->hasAccess('order-statuses.delete');
                }
            ]
        );

        // Deliveries
        $permissions->add(
            'deliveries',
            __('cms-orders::admin.deliveries.Deliveries'),
            [
                'view',
//                'create',
                'edit',
                'edit-settings',
                'delete' => function (Administrator $administrator, Delivery $delivery) {
                    return !$delivery->driver && $administrator->hasAccess('deliveries.delete');
                }
            ]
        );

        // Payments
        $permissions->add(
            'payments',
            __('cms-orders::admin.payments.Payments'),
            [
                'view',
//                'create',
                'edit',
                'edit-settings',
                'delete' => function (Administrator $administrator, Payment $payment) {
                    return !$payment->driver && $administrator->hasAccess('payments.delete');
                }
            ]
        );
    }

    public function adminMenu()
    {
        $orders = SidebarMenu::get('orders');
        if (!$orders) {
            $orders = SidebarMenu::add(__('cms-orders::admin.orders.Orders'))
                ->data('icon', 'fa-shopping-cart')
                ->data('badge_type', 'warning')
                ->data('position', 10)
                ->nickname('orders');
        }

        $count = Order::new()->count();

        $orders->data('badge', $orders->data('badge') + $count);

        // Main orders
        $orders->add(__('cms-orders::admin.orders.Orders'), route('admin.orders.index'))
            ->data('permission', 'orders.view')
            ->data('badge', $count)
            ->data('badge_type', 'warning')
            ->data('icon', 'fa-shopping-bag')
            ->data('position', 1);

        // Statuses
        $orders->add(__('cms-orders::admin.statuses.Statuses'), route('admin.order-statuses.index'))
            ->data('permission', 'order-statuses.view')
            ->data('icon', 'fa-bookmark-o')
            ->data('position', 3);

        // Deliveries
        $orders->add(__('cms-orders::admin.deliveries.Deliveries'), route('admin.deliveries.index'))
            ->data('permission', 'deliveries.view')
            ->data('icon', 'fa-truck')
            ->data('position', 8);

        // Payments
        $orders->add(__('cms-orders::admin.payments.Payments'), route('admin.payments.index'))
            ->data('permission', 'payments.view')
            ->data('icon', 'fa-money')
            ->data('position', 9);
    }

    /**
     * Register module listeners.
     */
    protected function registerListeners()
    {
        parent::registerListeners();

        if (!app('isBackend')) {
            Event::listen(CreatedOrder::class, SendCreatedOrderNotification::class);
            Event::listen(AutoPayedOrder::class, SendAutoPayedOrderNotification::class);

            Event::listen('created_product_review', function (ProductReview $review) {
                if (Auth::guest()) {
                    return;
                }

                $exists = OrderItem::where('product_id', $review->product_id)
                    ->whereHas('order', function ($query) {
                        $query->where('user_id', Auth::user()->getAuthIdentifier());
                    })->exists();

                if ($exists) {
                    $review->update(['already_bought' => true]);
                }
            });

            Event::listen('register_csrf_except_uri', function () {
                $except = ['payment-callback/*'];
                foreach (array_keys(app('locales')) as $locale) {
                    $except[] = "{$locale}/payment-callback/*";
                }
                return $except;
            });
        }

        if ($this->app->runningInConsole()) {
            Event::listen('cms:install:after_migrate', function (Command $command) {
                $force = (bool) $command->option('force');
                if (
                    Communication::doesntExist()
                    && $command->confirm('Do your want run seed "Create communications values"', 'yes')
                ) {
                    $command->call('db:seed', ['--class' => CommunicationsSeeder::class, '--force' => $force]);
                }

                if (
                    Delivery::doesntExist()
                    && $command->confirm('Do your want run seed "Create deliveries values"', 'yes')
                ) {
                    $command->call('db:seed', ['--class' => DeliveriesSeeder::class, '--force' => $force]);
                }

                if (
                    Payment::doesntExist()
                    && $command->confirm('Do your want run seed "Create payments values"', 'yes')
                ) {
                    $command->call('db:seed', ['--class' => PaymentsSeeder::class, '--force' => $force]);
                }

                if (
                    OrderStatus::doesntExist()
                    && $command->confirm('Do your want run seed "Create basic order statuses"', 'yes')
                ) {
                    $command->call('db:seed', ['--class' => OrderStatusesSeeder::class, '--force' => $force]);
                }
            });

            Event::listen('cms:install', function (Command $command) {
                $command->call(
                    'vendor:publish',
                    ['--provider' => static::class, '--tag' => 'assets']
                );
            });
        }

        Order::observe(OrderObserver::class);
    }

    /**
     * Add custom schedule jobs.
     *
     * @param  Schedule  $schedule
     */
    public function jobs(Schedule $schedule)
    {
        try {
            $cart = $this->app[CartInterface::class];

            if ($cart instanceof NeedClearOldHashesInterface) {
                $schedule->call(function () use ($cart) {
                    $cart->clearOldHashes();
                })->dailyAt('01:00');
            }
        } catch (\Exception $e) {
            logger($e->getMessage());
        }
    }
}
