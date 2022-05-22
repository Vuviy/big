<?php

namespace WezomCms\Contacts\Widgets;

use Illuminate\Support\Str;
use WezomCms\Core\Foundation\Widgets\AbstractWidget;
use WezomCms\Core\Models\Setting;
use WezomCms\Core\Models\SettingTranslation;
use WezomCms\Core\Models\Translation;

class SocialLinks extends AbstractWidget
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
        $siteSettings = settings('contacts.site', []);

        $socials = array_filter([
            'instagram' => array_get($siteSettings, 'instagram'),
            'telegram' => array_get($siteSettings, 'telegram'),
            'viber' => array_get($siteSettings, 'viber'),
            'facebook' => array_get($siteSettings, 'facebook')
        ]);

        if (empty($socials)) {
            return null;
        }

        return compact('socials');
    }
}
