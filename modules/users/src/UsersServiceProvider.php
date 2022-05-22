<?php

namespace WezomCms\Users;

use Config;
use Lavary\Menu\Builder;
use Menu;
use SidebarMenu;
use WezomCms\Core\BaseServiceProvider;
use WezomCms\Core\Contracts\PermissionsContainerInterface;
use WezomCms\Core\Foundation\Helpers;
use WezomCms\Favorites\FavoritesServiceProvider;
use WezomCms\Orders\OrdersServiceProvider;
use WezomCms\Users\Events\AutoRegistered;
use WezomCms\Users\Http\Middleware\EnsureEmailIsVerified;
use WezomCms\Users\Listeners\SendAutoGeneratedPasswordNotification;
use WezomCms\Users\Models\User;
use WezomCms\Users\Notifications\Channels\ESputnikChannel;

class UsersServiceProvider extends BaseServiceProvider
{
    /**
     * All module widgets.
     *
     * @var array|string|null
     */
    protected $widgets = 'cms.users.users.widgets';

    /**
     * Dashboard widgets.
     *
     * @var array|string|null
     */
    protected $dashboard = 'cms.users.users.dashboards';

    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        AutoRegistered::class => [
            SendAutoGeneratedPasswordNotification::class,
        ],
    ];

    /**
     * Custom translation keys.
     *
     * @var array
     */
    protected $translationKeys = [
        'cms-users::site.auth.passwords.password',
        'cms-users::site.auth.passwords.reset',
        'cms-users::site.auth.passwords.sent',
        'cms-users::site.auth.passwords.token',
        'cms-users::site.auth.passwords.user',
        'cms-users::site.auth.passwords.throttled',
        'cms-users::site.auth.code.passwords.password',
        'cms-users::site.auth.code.passwords.reset',
        'cms-users::site.auth.code.passwords.sent',
        'cms-users::site.auth.code.passwords.token',
        'cms-users::site.auth.code.passwords.user',
        'cms-users::site.facebook',
        'cms-users::site.google',
        'cms-users::site.twitter',
        'cms-user::site.communication.Телефон',
        'cms-user::site.communication.Viber',
        'cms-user::site.communication.Telegram'
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ESputnikChannel::class, function () {
            $config = settings('users.sms_service', []);

            return new ESputnikChannel(
                array_get($config, 'user'),
                array_get($config, 'password'),
                array_get($config, 'from')
            );
        });
    }

    /**
     * Application booting.
     */
    public function boot()
    {
        $this->app['router']->aliasMiddleware('verified', EnsureEmailIsVerified::class);

        $this->app['config']->set('auth.providers.users', ['driver' => 'activeEloquentUser', 'model' => User::class]);

        $this->app->singleton('cabinetMenu', function ($app) {
            return Menu::make('cabinetMenu', function (Builder $menu) {
                $menu->add(__('cms-users::site.cabinet.Personal info'), route('cabinet'))
                    ->data('position', 1)
                    ->nickname('cabinet');
                if (Helpers::providerLoaded(FavoritesServiceProvider::class)) {
                    $menu->add(__('cms-favorites::site.Wish list'), ['url' => route('favorites'), 'counter' => 'favorites.cabinet-menu-counter'])
                        ->data('position', 3);
                }
                if (Helpers::providerLoaded(OrdersServiceProvider::class)) {
                    $menu->add(__('cms-orders::site.history.Orders history'),
                        ['url' => route('cabinet.orders'), 'counter' => 'orders.cabinet-menu-counter'])
                        ->data('position', 2)
                        ->nickname('cabinet.orders');
                }
            });
        });

        parent::boot();
    }

    /**
     * Load module config.
     */
    protected function config()
    {
        parent::config();

        $this->app->booted(function () {
            /** @var Config $config */
            $config = $this->app['config'];

            $settings = settings('users.socials', []);
            // Add social keys
            foreach ($config->get('cms.users.users.supported_socials') as $social) {
                $config->set("services.{$social}", [
                    'client_id' => array_get($settings, "{$social}_id"),
                    'client_secret' => array_get($settings, "{$social}_secret_key"),
                    'redirect' => "/socialite/{$social}/callback",
                ]);
            }

//            // Configure turbosms
//            if ($config->get('cms.users.users.sms_service') === 'turbosms') {
//                $turboSmsSettings = settings('users.sms_service', []);
//                $config->set('services.turbosms', [
//                    'login' => array_get($turboSmsSettings, 'login'),
//                    'secret' => array_get($turboSmsSettings, 'secret'),
//                    'sender' => array_get($turboSmsSettings, 'sender', 'Msg'),
//                    'url' => 'http://turbosms.in.ua/api/wsdl.html',
//                ]);
//            }
        });
    }

    /**
     * @param  PermissionsContainerInterface  $permissions
     */
    public function permissions(PermissionsContainerInterface $permissions)
    {
        $permissions->add('users', __('cms-users::admin.Users'))->withEditSettings();
        $permissions->add('user-addresses', __('cms-users::admin.Адреса'));
    }

    public function adminMenu()
    {
        $usersMenu = SidebarMenu::add(__('cms-users::admin.Users'), route('admin.users.index'))
            ->data('icon', 'fa-users')
            ->nickname('users')
            ->data('position', 41);

        $usersMenu->add(__('cms-users::admin.Users'), route('admin.users.index'))
            ->data('icon', 'fa-users')
            ->data('permission', 'users.view')
            ->data('position', 1);

        $usersMenu->add(__('cms-users::admin.Адреса'), route('admin.user-addresses.index'))
            ->data('icon', 'fa-map-marker')
            ->data('permission', 'user-addresses.view')
            ->data('position', 2);
    }
}
