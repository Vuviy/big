<?php

namespace WezomCms\Favorites\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

class SortVariant extends Enum implements LocalizedEnum
{
    public const TOP = 'top';
    public const CHEAP = 'cheap';
    public const EXPENSIVE = 'expensive';
    public const NOVELTY = 'novelty';

    /**
     * Get the default localization key
     *
     * @return string
     */
    public static function getLocalizationKey(): string
    {
        return 'cms-favorites::' . app('side') . '.sort_variant';
    }
}
