<?php

namespace WezomCms\Branches\Dashboards;

use WezomCms\Branches\Models\Branch;
use WezomCms\Core\Foundation\Dashboard\AbstractValueDashboard;

class BranchesDashboard extends AbstractValueDashboard
{
    /**
     * @var null|int - cache time in minutes.
     */
    protected $cacheTime = 5;

    /**
     * @var null|string - permission for link
     */
    protected $ability = 'branches.view';

    /**
     * @return int
     */
    public function value(): int
    {
        return Branch::count();
    }

    /**
     * @return string
     */
    public function description(): string
    {
        return __('cms-branches::admin.Branches');
    }

    /**
     * @return string
     */
    public function icon(): string
    {
        return 'fa-university';
    }

    /**
     * @return string
     */
    public function iconColorClass(): string
    {
        return 'color-warning';
    }

    /**
     * @return null|string
     */
    public function url(): ?string
    {
        return route('admin.branches.index');
    }
}
