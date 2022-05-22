<?php

namespace WezomCms\About\Http\Controllers\Admin;

use WezomCms\Core\Http\Controllers\SingleSettingsController;
use WezomCms\Core\Settings\Fields\AbstractField;
use WezomCms\Core\Settings\Fields\Image;
use WezomCms\Core\Settings\Fields\Textarea;
use WezomCms\Core\Settings\Fields\Wysiwyg;
use WezomCms\Core\Settings\MetaFields\SeoFields;
use WezomCms\Core\Settings\MultilingualGroup;
use WezomCms\Core\Settings\RenderSettings;

class AboutController extends SingleSettingsController
{
    /**
     * @return null|string
     */
    protected function abilityPrefix(): ?string
    {
        return 'about';
    }

    /**
     * @return string|null
     */
    protected function frontUrl(): ?string
    {
        return route('about');
    }

    /**
     * Page title.
     *
     * @return string
     */
    protected function title(): string
    {
        return __('cms-about::admin.About');
    }

    /**
     * @return array|AbstractField[]|MultilingualGroup[]
     * @throws \Exception
     */
    protected function settings(): array
    {
        $result = [];

        $contentBannerTitle = Textarea::make()
            ->setIsMultilingual()
            ->setName(__('cms-about::admin.Content banner title'))
            ->setKey('content_banner_title')
            ->setRules('required|string|max:65535')
            ->setSort(10);

        $descriptionUnderHeading = Wysiwyg::make()
            ->setIsMultilingual()
            ->setName(__('cms-about::admin.Description under the heading'))
            ->setKey('description_under_heading')
            ->setRules('required|string|max:30000')
            ->setSort(11);

        $imageBlockDescription = Image::make()
            ->setIsMultilingual()
            ->setName(__('cms-about::admin.Image block description'))
            ->setKey('image_block_description')
            ->setSort(12)
            ->setSettings('cms.about.about.images.about')
            ->setRules('required|image|max:1024');

        $quoteBlockDescription = Textarea::make()
            ->setIsMultilingual()
            ->setName(__('cms-about::admin.Quote block description'))
            ->setKey('quote_block_description')
            ->setRules('required|string|max:65535')
            ->setSort(13);

        $descriptionBlockDescription = Wysiwyg::make()
            ->setIsMultilingual()
            ->setName(__('cms-about::admin.Description block description'))
            ->setKey('description_block_description')
            ->setRules('required|string|max:30000')
            ->setSort(14);

        $result[] = SeoFields::make(__('cms-about::admin.About'), [
            $contentBannerTitle,
            $descriptionUnderHeading,
            $imageBlockDescription,
            $quoteBlockDescription,
            $descriptionBlockDescription,
        ], RenderSettings::siteTab(RenderSettings::SIDE_LEFT));

        return $result;
    }
}
