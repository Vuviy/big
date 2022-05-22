<?php

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use WezomCms\Core\Contracts\SettingsInterface;
use WezomCms\Core\Image\ImageService;
use WezomCms\Core\Services\PhoneMaskService;

if (!function_exists('settings')) {
    /**
     * @param  null|string  $key
     * @param  mixed  $default
     * @return mixed|SettingsInterface
     */
    function settings($key = null, $default = null)
    {
        /** @var SettingsInterface $settings */
        $settings = app(SettingsInterface::class);

        if (is_null($key)) {
            return $settings;
        }

        return $settings->get($key, $default);
    }
}

if (!function_exists('glob_recursive')) {
    /**
     * Find path names matching a pattern recursively
     *
     * @param $pattern
     * @param  int  $flags
     * @return array
     */
    function glob_recursive($pattern, $flags = 0)
    {
        $files = glob($pattern, $flags);
        foreach (glob(dirname($pattern) . '/*', GLOB_ONLYDIR | GLOB_NOSORT) as $dir) {
            $files = array_merge($files, glob_recursive($dir . '/' . basename($pattern), $flags));
        }

        return $files;
    }
}

if (!function_exists('route_localized')) {
    /**
     * Generate the URL to a named route based on current locale
     *
     * @param  array|string  $name
     * @param  mixed  $parameters
     * @param  bool  $absolute
     * @param  string|null  $locale
     * @return string
     */
    function route_localized($name, $parameters = [], $absolute = true, $locale = null)
    {
        return \LaravelLocalization::getLocalizedURL(
            $locale ? : app()->getLocale(),
            route($name, $parameters, $absolute)
        );
    }
}


if (!function_exists('image_url')) {
    /**
     * Generate the URL to image with .webp if browser support & file exists
     *
     * @param  string  $path
     * @param  mixed  $parameters
     * @param  bool|null  $secure
     * @return string
     */
    function image_url($path = null, $parameters = [], $secure = null)
    {
        if (ImageService::webPSupport() && is_file(public_path($path . '.webp'))) {
            $path .= '.webp';
        }

        return url($path, $parameters, $secure);
    }
}

if (!function_exists('published_scope')) {
    /**
     * Apply published scope.
     *
     * @return callable
     */
    function published_scope()
    {
        return function ($query) {
            $query->published();
        };
    }
}

if (!function_exists('published_sorted_scope')) {
    /**
     * Apply published scope.
     *
     * @return callable
     */
    function published_sorted_scope()
    {
        return function ($query) {
            $query->published()->sorting();
        };
    }
}

if (!function_exists('money')) {
    /**
     * @param  null  $amount
     * @param  bool  $currency
     * @return \WezomCms\Core\Foundation\Money|string
     */
    function money($amount = null, $currency = false)
    {
        $money = app('money');

        if (!$amount && func_num_args() === 0) {
            return $money;
        }

        $result = $money->format($amount);

        if ($currency) {
            return $money->addCurrency($result);
        }

        return $result;
    }
}

if (!function_exists('remove_phone_mask')) {
    /**
     * @param  string|null  $phone
     * @param  string|null  $format
     * @return string|null
     */
    function remove_phone_mask(?string $phone, ?string $format = null): ?string
    {
        return (new PhoneMaskService($format))->removePhoneMask($phone);
    }
}

if (!function_exists('apply_phone_mask')) {
    /**
     * @param  string|null  $phone
     * @param  string|null  $format
     * @return string
     */
    function apply_phone_mask(?string $phone, ?string $format = null): string
    {
        return (new PhoneMaskService($format))->applyMask($phone);
    }
}

if (!function_exists('getSvgList')) {
    /**
     * @param string $path
     * @return mixed
     */
    function getSvgList(string $path)
    {
        $svgPath = compiled_svg($path);
        if (strlen($svgPath) > 0) {

            preg_match_all('/ id="(.*?)"/', file_get_contents(public_path($svgPath)), $matches);
            $list = array_get($matches, 1, []);
            $list = array_combine($list, $list);

            return $list;
        }
        return [];
    }
}

if (!function_exists('setHttpsForLocalLinks')) {
    /**
     * @param string $url
     * @return string
     */
    function setHttpsForLocalLinks(?string $url): ?string
    {
        $urlData = parse_url($url);

        if ($url && str_contains($url, 'http://') && array_get($urlData, 'host') === request()->getHost()) {
            $url = str_replace('http://', 'https://', $url);
        }

        return $url;
    }

    if (!function_exists('count_more')) {
        function count_more(LengthAwarePaginator $paginator): int
        {
            $total = $paginator->total();
            $perPage = $paginator->perPage();
            $currentPage = $paginator->currentPage();

            if ($total > ($perPage * ($currentPage + 1))) {
                return $perPage;
            }

            return abs($total - $perPage * $currentPage);
        }
    }
}
