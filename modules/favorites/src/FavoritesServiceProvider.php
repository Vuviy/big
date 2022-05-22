<?php

namespace WezomCms\Favorites;

use Event;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use SidebarMenu;
use WezomCms\Core\BaseServiceProvider;
use WezomCms\Core\Contracts\PermissionsContainerInterface;
use WezomCms\Core\Foundation\Helpers;
use WezomCms\Favorites\Enums\SortVariant;
use WezomCms\Favorites\Listeners\SyncFavorites;
use WezomCms\Favorites\Models\Favorite;
use WezomCms\Users\Models\User;
use WezomCms\Users\UsersServiceProvider;

class FavoritesServiceProvider extends BaseServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [SyncFavorites::class],
        Login::class => [SyncFavorites::class],
        Verified::class => [SyncFavorites::class],
    ];

    /**
     * List of enum classes for auto scanning localization keys.
     *
     * @var array
     */
    protected $enumClasses = [
        SortVariant::class,
    ];

    /**
     * All module widgets.
     *
     * @var array|string|null
     */
    protected $widgets = 'cms.favorites.favorites.widgets';

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('favorites', function ($app) {
            return new FavoriteManager($app);
        });

        $this->app->singleton('favorites.store', function ($app) {
            return $app['favorites']->driver();
        });
    }

    /**
     * Application booting.
     */
    public function boot()
    {
        if (Helpers::providerLoaded(UsersServiceProvider::class)) {
            User::addExternalMethod('favorites', function () {
                /** @var User $this */
                return $this->hasMany(Favorite::class);
            });
        }

        parent::boot();
    }

    /**
     * @param  PermissionsContainerInterface  $permissions
     */
    public function permissions(PermissionsContainerInterface $permissions)
    {
        $permissions->editSettings('favorites', __('cms-favorites::admin.Edit favorites settings'));
    }

    public function adminMenu()
    {
        SidebarMenu::add(__('cms-favorites::admin.Favorites'), route('admin.favorites.settings'))
            ->data('permission', 'favorites.edit-settings')
            ->data('icon', 'fa-heart')
            ->data('position', 14)
            ->nickname('favorites-settings');
    }
}
