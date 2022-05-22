<?php

namespace WezomCms\Newsletter\Dashboards;

use WezomCms\Core\Foundation\Dashboard\AbstractValueDashboard;
use WezomCms\Newsletter\Models\Subscriber;

class SubscribersDashboard extends AbstractValueDashboard
{
    /**
     * @var null|string - permission for link
     */
    protected $ability = 'subscribers.view';

    /**
     * @return int
     */
    public function value(): int
    {
        return Subscriber::count();
    }

    /**
     * @return string
     */
    public function description(): string
    {
        return __('cms-newsletter::admin.Subscribers');
    }

    /**
     * @return string
     */
    public function icon(): string
    {
        return 'fa-rss';
    }

    /**
     * @return null|string
     */
    public function url(): ?string
    {
        return route('admin.subscribers.index');
    }
}
