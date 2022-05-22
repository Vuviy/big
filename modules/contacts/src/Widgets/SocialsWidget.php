<?php

namespace WezomCms\Contacts\Widgets;

use WezomCms\Core\Foundation\Widgets\AbstractWidget;

class SocialsWidget extends AbstractWidget
{
    /**
     * View name.
     *
     * @var string|null
     */
    protected $view = 'cms-contacts::site.widgets.socials-widget';

    /**
     * @return array|null
     */
    public function execute(): ?array
    {
        $siteSettings = settings('contacts.social', []);

        $socials = array_filter([
            'viber' => array_get($siteSettings, 'viber'),
            'telegram' => array_get($siteSettings, 'telegram'),
            'facebook' => array_get($siteSettings, 'facebook'),
        ]);

        /*if (empty($socials)) {
            return null;
        }*/

        return compact('socials');
    }
}
