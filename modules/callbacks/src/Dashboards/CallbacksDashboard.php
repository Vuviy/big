<?php

namespace WezomCms\Callbacks\Dashboards;

use WezomCms\Callbacks\Models\Callback;
use WezomCms\Core\Foundation\Dashboard\AbstractValueDashboard;

class CallbacksDashboard extends AbstractValueDashboard
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
        return Callback::count();
    }

    /**
     * @return string
     */
    public function description(): string
    {
        return __('cms-callbacks::admin.Callback');
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
        return 'color-success';
    }

    /**
     * @return null|string
     */
    public function url(): ?string
    {
        return route('admin.callbacks.index');
    }
}
