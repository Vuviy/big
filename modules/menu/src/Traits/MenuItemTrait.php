<?php

namespace WezomCms\Menu\Traits;

use LaravelLocalization;
use Request;
use WezomCms\Menu\Models\Menu;

/**
 * Trait MenuItemTrait
 * @package WezomCms\Core\Traits\Model
 */
trait MenuItemTrait
{
    abstract function getFrontUrl(): string;

    /**
     * @return string|null
     */
    public function activeMode(): ?string
    {
        $currentUrl = Request::getRequestUri();

        $url = parse_url($this->getFrontUrl(), PHP_URL_PATH);

        if ($url === $currentUrl) {
            return Menu::MODE_SPAN;
        }

        $defaultLocale = LaravelLocalization::getDefaultLocale();

        $trimmedUrl = preg_replace("#^(\/{$defaultLocale}|{$defaultLocale})#", '', $url);
        $trimmedUrl = '/' . ltrim($trimmedUrl, '/');

        if ($trimmedUrl === $currentUrl) {
            return Menu::MODE_SPAN;
        }

        // Remove current locale
        $locale = app()->getLocale();
        $trimmedUrl = preg_replace("#^\/{$locale}#", '', $trimmedUrl);
        $currentUrl = preg_replace("#^(\/{$locale}|{$locale})#", '', $currentUrl);

        if ($currentUrl !== '/' && $url !== '/' && $trimmedUrl && strpos($currentUrl, $trimmedUrl) === 0) {
            return Menu::MODE_LINK;
        }

        return null;
    }
}
