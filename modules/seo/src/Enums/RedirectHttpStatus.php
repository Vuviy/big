<?php

namespace WezomCms\Seo\Enums;

use BenSampo\Enum\Enum;

final class RedirectHttpStatus extends Enum
{
    public const STATUS_301 = 301;
    public const STATUS_302 = 302;
    public const STATUS_303 = 303;
    public const STATUS_307 = 307;

    /**
     * Get the enum as an array formatted for a select.
     *
     * [mixed $value => string description]
     *
     * @return array
     */
    public static function asSelectArray(): array
    {
        return [
            '' => __('cms-core::admin.layout.Not set'),
            self::STATUS_301 => __('cms-seo::admin.redirects.301 Moved Permanently «перемещено навсегда»'),
            self::STATUS_302 => __('cms-seo::admin.redirects.302 Moved Temporarily «перемещено временно»'),
            self::STATUS_303 => __('cms-seo::admin.redirects.303 See Other смотреть другое'),
            self::STATUS_307 => __('cms-seo::admin.redirects.307 Temporary Redirect «временное перенаправление»'),
        ];
    }
}
