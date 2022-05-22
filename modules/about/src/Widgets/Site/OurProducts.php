<?php

namespace WezomCms\About\Widgets\Site;

use WezomCms\Core\Foundation\Widgets\AbstractWidget;
use WezomCms\Core\Models\Setting;
use WezomCms\Core\Models\SettingTranslation;
use WezomCms\Core\Models\Translation;

class OurProducts extends AbstractWidget
{
    /**
     * A list of models that, when changed, will clear the cache of this widget.
     *
     * @var array
     */
    public static $models = [Setting::class, SettingTranslation::class, Translation::class];

    /**
     * @return array|null
     */
    public function execute(): ?array
    {
        $settings = settings('about.site', []);

        if (empty(array_filter($settings))) {
            return null;
        }

        return [
            'settings' => $settings
        ];
    }
}
