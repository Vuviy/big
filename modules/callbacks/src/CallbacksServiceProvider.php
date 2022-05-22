<?php

namespace WezomCms\Callbacks;

use SidebarMenu;
use WezomCms\Callbacks\Models\Callback;
use WezomCms\Core\BaseServiceProvider;
use WezomCms\Core\Contracts\PermissionsContainerInterface;

class CallbacksServiceProvider extends BaseServiceProvider
{
    /**
     * All module widgets.
     *
     * @var array|string|null
     */
    protected $widgets = 'cms.callbacks.callbacks.widgets';

    /**
     * Dashboard widgets.
     *
     * @var array|string|null
     */
    protected $dashboard = 'cms.callbacks.callbacks.dashboards';

    /**
     * @param  PermissionsContainerInterface  $permissions
     */
    public function permissions(PermissionsContainerInterface $permissions)
    {
        $permissions->add('callbacks', __('cms-callbacks::admin.Callbacks'))->withEditSettings();
    }

    public function adminMenu()
    {
        $count = Callback::where('read', 0)->count();

        SidebarMenu::add(__('cms-callbacks::admin.Callbacks'), route('admin.callbacks.index'))
            ->data('permission', 'callbacks.view')
            ->data('icon', 'fa-phone')
            ->data('badge', $count)
            ->data('badge_type', 'warning')
            ->data('position', 15);
    }
}
