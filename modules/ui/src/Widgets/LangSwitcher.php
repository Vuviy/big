<?php

namespace WezomCms\Ui\Widgets;

use LaravelLocalization;
use WezomCms\Core\Foundation\Widgets\AbstractWidget;

class LangSwitcher extends AbstractWidget
{
    /**
     * View name.
     *
     * @var string|null
     */
    protected $view = 'cms-ui::widgets.lang-switcher';

    /**
     * @return array|null
     * @throws \Mcamara\LaravelLocalization\Exceptions\SupportedLocalesNotDefined
     * @throws \Mcamara\LaravelLocalization\Exceptions\UnsupportedLocaleException
     */
    public function execute(): ?array
    {
        // Do not display widget if less than 2 languages.
        if (count(app('locales')) < 2) {
            return null;
        }

        $links = LaravelLocalization::getSwitchingLinks();

        $current = array_filter($links, function ($link) {
            return $link['active'];
        });
        reset($current);
        $currentLocale = key($current);

        $current = array_first($current);
        $current['locale'] = $currentLocale;

        return compact('links', 'current');
    }
}
