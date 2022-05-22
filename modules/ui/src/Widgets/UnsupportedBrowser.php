<?php

namespace WezomCms\Ui\Widgets;

use Browser;
use WezomCms\Core\Foundation\Widgets\AbstractWidget;
use WezomCms\Ui\Client\ModernBrowserChecker;

class UnsupportedBrowser extends AbstractWidget
{
    private const DEFAULT_DOWNLOAD_LINK = 'https://www.google.com/chrome';

    /**
     * View name.
     *
     * @var string|null
     */
    protected $view = 'cms-ui::widgets.unsupported-browser';

    /**
     * @param  ModernBrowserChecker  $modernBrowserChecker
     * @return array|null
     * @throws \Exception
     */
    public function execute(ModernBrowserChecker $modernBrowserChecker): ?array
    {
        if ($modernBrowserChecker->isModern() || Browser::isBot()) {
            return null;
        }

        return ['updateBrowserLink' => $this->guestUpdateBrowserLink()];
    }

    /**
     * @return string
     */
    protected function guestUpdateBrowserLink(): string
    {
        if (Browser::isMobile() || Browser::isTablet()) {
            $isIos = Browser::isMac();
            switch (true) {
                case Browser::isChrome():
                    return $isIos
                        ? 'https://apps.apple.com/app/google-chrome/id535886823'
                        : 'https://play.google.com/store/apps/details?id=com.android.chrome';
                case Browser::isFirefox():
                    return $isIos
                        ? 'https://apps.apple.com/ca/app/firefox-private-safe-browser/id989804926'
                        : 'https://play.google.com/store/apps/details?id=org.mozilla.firefox';
                case Browser::isOpera():
                    return $isIos
                        ? 'https://apps.apple.com/ca/app/opera-browser-fast-private/id1411869974'
                        : 'https://play.google.com/store/apps/details?id=com.opera.browser';
                case Browser::isSafari():
                    return 'https://support.apple.com/downloads/safari';
                case Browser::isIE():
                case Browser::isEdge():
                    return 'https://play.google.com/store/apps/details?id=com.microsoft.emmx';
            }
        } else {
            switch (true) {
                case Browser::isChrome():
                    return self::DEFAULT_DOWNLOAD_LINK;
                case Browser::isFirefox():
                    return 'https://www.mozilla.org/ru/firefox/new';
                case Browser::isOpera():
                    return 'https://www.opera.com/ru/download';
                case Browser::isSafari():
                    return 'https://support.apple.com/downloads/safari';
                case Browser::isIE():
                case Browser::isEdge():
                    return 'https://www.microsoft.com/edge';
            }
        }

        return self::DEFAULT_DOWNLOAD_LINK;
    }
}
