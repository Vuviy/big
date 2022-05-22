<?php

namespace WezomCms\Menu;

use Event;
use Illuminate\Console\Command;
use WezomCms\Core\BaseServiceProvider;
use WezomCms\Core\Contracts\Assets\AssetManagerInterface;
use WezomCms\Core\Contracts\PermissionsContainerInterface;
use WezomCms\Core\Traits\SidebarMenuGroupsTrait;

class MenuServiceProvider extends BaseServiceProvider
{
    use SidebarMenuGroupsTrait;

    /**
     * All module widgets.
     *
     * @var array|string|null
     */
    protected $widgets = 'cms.menu.menu.widgets';

    /**
     * Custom translation keys.
     *
     * @var array
     */
    protected $translationKeys = [
        'cms-menu::admin.Header',
        'cms-menu::admin.Header catalog categories',
        'cms-menu::admin.Footer',
        'cms-menu::admin.Mobile',
    ];

    /**
     * @param  PermissionsContainerInterface  $permissions
     */
    public function permissions(PermissionsContainerInterface $permissions)
    {
        $permissions->add('menu', __('cms-menu::admin.Menu'));
    }

    public function adminMenu()
    {
        $this->serviceGroup()->add(__('cms-menu::admin.Menu'), route('admin.menu.index'))
            ->data('permission', 'menu.view')
            ->data('icon', 'fa-map-signs')
            ->nickname('menu');
    }

    protected function afterBootForAdminPanel()
    {
        app(AssetManagerInterface::class)
            ->addJs('vendor/cms/menu/menu.js', 'menu')
            ->group(AssetManagerInterface::GROUP_ADMIN);
    }

    /**
     * Register module listeners.
     */
    protected function registerListeners()
    {
        parent::registerListeners();

        if ($this->app->runningInConsole()) {
            Event::listen('cms:install', function (Command $command) {
                $command->call(
                    'vendor:publish',
                    ['--provider' => static::class, '--tag' => 'assets']
                );
            });
        }
    }
}
