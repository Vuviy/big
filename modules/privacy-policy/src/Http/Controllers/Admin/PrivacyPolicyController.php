<?php

namespace WezomCms\PrivacyPolicy\Http\Controllers\Admin;

use WezomCms\Core\Http\Controllers\SingleSettingsController;
use WezomCms\Core\Settings\Fields\AbstractField;
use WezomCms\Core\Settings\MetaFields\SeoFields;
use WezomCms\Core\Settings\MetaFields\SeoText;
use WezomCms\Core\Settings\MultilingualGroup;

class PrivacyPolicyController extends SingleSettingsController
{
    /**
     * @return null|string
     */
    protected function abilityPrefix(): ?string
    {
        return 'privacy-policy';
    }

    /**
     * @return string|null
     */
    protected function frontUrl(): ?string
    {
        return route('privacy-policy');
    }

    /**
     * Page title.
     *
     * @return string
     */
    protected function title(): string
    {
        return __('cms-privacy-policy::admin.Privacy policy');
    }

    /**
     * @return array|AbstractField[]|MultilingualGroup[]
     * @throws \Exception
     */
    protected function settings(): array
    {
        return [
            SeoFields::make(
                'Privacy policy',
                [SeoText::make()->setName(__('cms-privacy-policy::admin.Text'))->setSort(3)]
            ),
        ];
    }
}
