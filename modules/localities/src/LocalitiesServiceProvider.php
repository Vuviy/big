<?php

namespace WezomCms\Localities;

use SidebarMenu;
use WezomCms\Core\BaseServiceProvider;
use WezomCms\Core\Contracts\PermissionsContainerInterface;

class LocalitiesServiceProvider extends BaseServiceProvider
{
    /**
     * @param  PermissionsContainerInterface  $permissions
     */
    public function permissions(PermissionsContainerInterface $permissions)
    {
        $permissions->add('cities', __('cms-localities::admin.Cities'));
        $permissions->add('localities', __('cms-localities::admin.Localities'));
    }

    public function adminMenu()
    {
        $group = SidebarMenu::get('location-group');

        if (!$group) {
            $group = SidebarMenu::add(__('cms-localities::admin.Locations'))
                ->data('icon', 'fa-map-marker')
                ->data('position', 6)
                ->nickname('location-group');
        }

        $group->add(__('cms-localities::admin.Cities'), route('admin.cities.index'))
            ->data('permission', 'cities.view')
            ->data('icon', 'fa-building-o')
            ->data('position', 1)
            ->nickname('cities');

        $group->add(__('cms-localities::admin.Localities'), route('admin.localities.index'))
            ->data('permission', 'localities.view')
            ->data('icon', 'fa-map')
            ->data('position', 3)
            ->nickname('localities');
    }
}
