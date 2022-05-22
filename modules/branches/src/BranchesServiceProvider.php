<?php

namespace WezomCms\Branches;

use WezomCms\Core\BaseServiceProvider;
use WezomCms\Core\Contracts\PermissionsContainerInterface;
use WezomCms\Core\Foundation\Dashboard\RegisterDashboardWidgetsTrait;
use WezomCms\Core\Foundation\Widgets\RegisterWidgetsTrait;

class BranchesServiceProvider extends BaseServiceProvider
{
    use RegisterWidgetsTrait;
    use RegisterDashboardWidgetsTrait;

    /**
     * All module widgets.
     *
     * @var array|string|null
     */
    protected $widgets = 'cms.branches.branches.widgets';

    /**
     * Dashboard widgets.
     *
     * @var array|string|null
     */
    protected $dashboard = 'cms.branches.branches.dashboards';

    /**
     * @param  PermissionsContainerInterface  $permissions
     */
    public function permissions(PermissionsContainerInterface $permissions)
    {
        $permissions->add('branches', __('cms-branches::admin.Branches'))->withEditSettings();
    }
}
