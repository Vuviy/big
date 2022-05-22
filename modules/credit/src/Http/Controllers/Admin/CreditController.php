<?php

namespace WezomCms\Credit\Http\Controllers\Admin;

use WezomCms\Core\Http\Controllers\SingleSettingsController;
use WezomCms\Core\Settings\Fields\AbstractField;
use WezomCms\Core\Settings\Fields\Input;
use WezomCms\Core\Settings\Fields\Textarea;
use WezomCms\Core\Settings\MultilingualGroup;
use WezomCms\Core\Settings\RenderSettings;
use WezomCms\Core\Settings\Tab;

class CreditController extends SingleSettingsController
{
    /**
     * Page title.
     *
     * @return string
     */
    protected function title(): string
    {
        return __('cms-credit::admin.Credit');
    }

    /**
     * @return array|AbstractField[]|MultilingualGroup[]
     * @throws \Exception
     */
    protected function settings(): array
    {
        return $this->popup();
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function popup(): array
    {
        return [
            MultilingualGroup::make(
                new RenderSettings(new Tab('popup', __('cms-credit::admin.Popup'), 2)),
                [
                    Input::make()
                        ->setIsMultilingual()
                        ->setKey('title')
                        ->default('Кредит/Рассрочка')
                        ->setName(__('cms-credit::admin.Title'))
                        ->setRules('nullable|string|max:150'),
                    Textarea::make()
                        ->setIsMultilingual()
                        ->setKey('description')
                        ->setName(__('cms-credit::admin.Description'))
                        ->setRules('nullable|string|max:500')
                ]
            ),
        ];
    }

}
