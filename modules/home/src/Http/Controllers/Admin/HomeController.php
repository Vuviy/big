<?php

namespace WezomCms\Home\Http\Controllers\Admin;

use WezomCms\Core\Http\Controllers\SingleSettingsController;
use WezomCms\Core\Settings\Fields\AbstractField;
use WezomCms\Core\Settings\MetaFields\SeoFields;
use WezomCms\Core\Settings\MetaFields\SeoText;
use WezomCms\Core\Settings\MultilingualGroup;

class HomeController extends SingleSettingsController
{
    /**
     * @return null|string
     */
    protected function abilityPrefix(): ?string
    {
        return 'home';
    }

    /**
     * @return string|null
     */
    protected function frontUrl(): ?string
    {
        return route('home');
    }

    /**
     * Page title.
     *
     * @return string
     */
    protected function title(): string
    {
        return __('cms-home::admin.Home');
    }

    /**
     * @return array|AbstractField[]|MultilingualGroup[]
     * @throws \Exception
     */
    protected function settings(): array
    {
        return [
            SeoFields::make('Home', [SeoText::make()]),
        ];
    }
}
