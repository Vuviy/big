<?php

use WezomAgency\R2D2;
use WezomCms\Ui\Ui;

if (!function_exists('svg')) {
    /**
     * Render svg element.
     *
     * @param  string  $sprite
     * @param  string  $id
     * @param  int|array|string  $size
     * @param  string|null  $class
     * @param  array  $attributes
     * @return \Illuminate\Support\HtmlString
     */
    function svg(string $sprite, string $id, $size = [], ?string $class = null, array $attributes = [])
    {
        return app(Ui::class)->svg(...func_get_args());
    }
}

if (!function_exists('src')) {
    /**
     * Replaces paths compiled assets from generated manifests
     *
     * @param string $path
     * @return string
     */
    function src(string $path)
    {
        return app(Ui::class)->src(...func_get_args());
    }
}

if (!function_exists('r2d2')) {
    /**
     * Get R2D2 instance
     *
     * @return R2D2
     */
    function r2d2()
    {
        return R2D2::eject();
    }
}

if (!function_exists('compiled_svg')) {
    /**
     * Replaces paths compiled SVG sets from generated manifests
     *
     * @param  string  $path
     * @param  string|null  $symbol
     * @return string
     */
    function compiled_svg(string $path, string $symbol = null)
    {
        static $manifest;

        if (null === $manifest) {
            $json = file_get_contents(public_path('/svg/manifest.json'));
            $manifest = json_decode($json, true);
        }

        if (array_key_exists($path, $manifest)) {
            $hash = $symbol ? ('#' . $symbol) : '';
            return $manifest[$path] . $hash;
        }
        return '';
    }
}

if (!function_exists('localizedDate')) {
    function localizedDate(\Carbon\Carbon $datetime): string
    {
        return $datetime->isoFormat('D MMMM YYYY', 'Do MMMM');
    }
}
