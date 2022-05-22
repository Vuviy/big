<?php

namespace WezomCms\ProductReviews\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

class Ratings extends Enum implements LocalizedEnum
{
    public const VERY_BAD = 1;
    public const BAD = 2;
    public const AVERAGE = 3;
    public const GOOD = 4;
    public const EXCELLENT = 5;

    /**
     * Get the default localization key
     *
     * @return string
     */
    public static function getLocalizationKey(): string
    {
        return 'cms-product-reviews::site.ratings';
    }
}
