<?php

namespace WezomCms\Seo\Http\Controllers\Admin;

use WezomCms\Core\Http\Controllers\SingleSettingsController;
use WezomCms\Core\Settings\Fields\AbstractField;
use WezomCms\Core\Settings\Fields\Textarea;
use WezomCms\Core\Settings\MultilingualGroup;
use WezomCms\Core\Settings\RenderSettings;
use WezomCms\Core\Settings\Tab;

class SeoController extends SingleSettingsController
{
    /**
     * @return array|AbstractField[]|MultilingualGroup[]
     * @throws \Exception
     */
    protected function settings(): array
    {
        $metrics = new RenderSettings(new Tab('metrics', __('cms-seo::admin.Metrics')));

        return [
            Textarea::make($metrics)
                ->setKey('head')
                ->setName(__('cms-seo::admin.Inside head tag'))
                ->setRules('nullable|string')
                ->setRows(13),
            Textarea::make($metrics)
                ->setKey('body')
                ->setName(__('cms-seo::admin.Inside body tag'))
                ->setRules('nullable|string')
                ->setRows(13),
            Textarea::make(new RenderSettings(new Tab('robots', __('cms-seo::admin.Robots'))))
                ->setKey('content')
                ->setName(__('cms-seo::admin.Content'))
                ->setHelpText(__('cms-seo::admin.For correct operation, the server should not have a robots file'))
                ->setRules('nullable|string')
                ->setRows(30),
        ];
    }

    /**
     * Page title.
     *
     * @return string
     */
    protected function title(): string
    {
        return __('cms-seo::admin.SEO');
    }
}
