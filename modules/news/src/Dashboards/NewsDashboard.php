<?php

namespace WezomCms\News\Dashboards;

use WezomCms\Core\Foundation\Dashboard\AbstractValueDashboard;
use WezomCms\News\Models\News;

class NewsDashboard extends AbstractValueDashboard
{
    /**
     * @var null|int - cache time in minutes.
     */
    protected $cacheTime = 5;

    /**
     * @var null|string - permission for link
     */
    protected $ability = 'news.view';

    /**
     * @return int
     */
    public function value(): int
    {
        return News::count();
    }

    /**
     * @return string
     */
    public function description(): string
    {
        return __('cms-news::admin.News');
    }

    /**
     * @return string
     */
    public function icon(): string
    {
        return 'fa-newspaper-o';
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
        return route('admin.news.index');
    }
}
