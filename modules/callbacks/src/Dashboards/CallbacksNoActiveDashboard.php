<?php

namespace WezomCms\Callbacks\Dashboards;

use WezomCms\Callbacks\Models\Callback;
use WezomCms\Core\Foundation\Dashboard\AbstractValueDashboard;

class CallbacksNoActiveDashboard extends AbstractValueDashboard
{
    /**
     * @var null|int - cache time in minutes.
     */
    protected $cacheTime = 5;

    /**
     * @var null|string - permission for link
     */
    protected $ability = 'callbacks.view';

    /**
     * @return int
     */
    public function value(): int
    {
        return Callback::where('read', 0)->count();
    }

    /**
     * @return string
     */
    public function description(): string
    {
        return __('cms-callbacks::admin.Callbacks new');
    }

    /**
     * @return string
     */
    public function icon(): string
    {
        return 'fa-phone';
    }

    /**
     * @return string
     */
    public function iconColorClass(): string
    {
        return 'color-danger';
    }

    /**
     * @return null|string
     */
    public function url(): ?string
    {
        return route('admin.callbacks.index', ['read' => 0]);
    }
}
