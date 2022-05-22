<?php

namespace WezomCms\Contacts\Widgets;

use WezomCms\Core\Foundation\Widgets\AbstractWidget;
use WezomCms\Core\Models\Setting;
use WezomCms\Core\Models\SettingTranslation;
use WezomCms\Core\Models\Translation;

class PhoneSocialLinks extends AbstractWidget
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
        $siteSettings = settings('contacts.social', []);

        $socials = array_filter([
            'telegram' => array_get($siteSettings, 'telegram'),
            'viber' => array_get($siteSettings, 'viber'),
        ]);

        if (empty($socials)) {
            return null;
        }

        return compact('socials');
    }
}
