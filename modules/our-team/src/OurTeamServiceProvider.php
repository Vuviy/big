<?php

namespace WezomCms\OurTeam;

use WezomCms\Core\BaseServiceProvider;
use WezomCms\Core\Contracts\PermissionsContainerInterface;
use WezomCms\Core\Traits\SidebarMenuGroupsTrait;

class OurTeamServiceProvider extends BaseServiceProvider
{
    use SidebarMenuGroupsTrait;

    /**
     * @param  PermissionsContainerInterface  $permissions
     */
    public function permissions(PermissionsContainerInterface $permissions)
    {
        $permissions->add('employees', __('cms-our-team::admin.Our team'))->withEditSettings();
    }
}
