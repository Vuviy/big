<?php

namespace WezomCms\Favorites\Http\Controllers\Admin;

use WezomCms\Core\Http\Controllers\SingleSettingsController;
use WezomCms\Core\Settings\Fields\AbstractField;
use WezomCms\Core\Settings\MultilingualGroup;
use WezomCms\Core\Settings\PageName;
use WezomCms\Core\Settings\RenderSettings;
use WezomCms\Core\Settings\SiteLimit;

class FavoritesController extends SingleSettingsController
{
    /**
     * @return null|string
     */
    protected function abilityPrefix(): ?string
    {
        return 'favorites';
    }

    /**
     * Page title.
     *
     * @return string
     */
    protected function title(): string
    {
        return __('cms-favorites::admin.Favorites');
    }

    /**
     * @return array|AbstractField[]|MultilingualGroup[]
     * @throws \Exception
     */
    protected function settings(): array
    {
        return [
            SiteLimit::make()->setName(__('cms-favorites::admin.Site favorites products limit at page')),
            MultilingualGroup::make(RenderSettings::siteTab(), [PageName::make()->default(__('cms-favorites::admin.Wish list'))]),
        ];
    }
}
