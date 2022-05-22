<?php

namespace WezomCms\Ui\Widgets;

use WezomCms\Core\Contracts\BreadcrumbsInterface;
use WezomCms\Core\Foundation\Helpers;
use WezomCms\Core\Foundation\Widgets\AbstractWidget;
use WezomCms\Home\HomeServiceProvider;

class Breadcrumbs extends AbstractWidget
{
    /**
     * View name.
     *
     * @var string|null
     */
    protected $view = 'cms-ui::widgets.breadcrumbs';

    /**
     * @param  BreadcrumbsInterface  $breadcrumbs
     * @return array|null
     */
    public function execute(BreadcrumbsInterface $breadcrumbs): ?array
    {
        $items = clone $breadcrumbs->getBreadcrumbs();

        if (Helpers::providerLoaded(HomeServiceProvider::class)) {
            // Add home
            $items->prepend([
                'name' => settings('home.site.name', __('cms-home::site.Home')),
                'link' => route('home')
            ]);
        }

        return compact('items');
    }
}
