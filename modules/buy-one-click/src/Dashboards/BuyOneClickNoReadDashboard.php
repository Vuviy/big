<?php

namespace WezomCms\BuyOneClick\Dashboards;

use WezomCms\BuyOneClick\Models\BuyOneClick;
use WezomCms\Core\Foundation\Dashboard\AbstractValueDashboard;

class BuyOneClickNoReadDashboard extends AbstractValueDashboard
{
    /**
     * @var null|int - cache time in minutes.
     */
    protected $cacheTime = 5;

    /**
     * @var null|string - permission for link
     */
    protected $ability = 'buy-one-click.view';

    /**
     * @return int
     */
    public function value(): int
    {
        return BuyOneClick::where('read', 0)->count();
    }

    /**
     * @return string
     */
    public function description(): string
    {
        return __('cms-buy-one-click::admin.Buy one click');
    }

    /**
     * @return string
     */
    public function icon(): string
    {
        return 'fa-rocket';
    }

    /**
     * @return null|string
     */
    public function url(): ?string
    {
        return route('admin.buy-one-click.index', ['read' => 0]);
    }
}
