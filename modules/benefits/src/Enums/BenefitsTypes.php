<?php

namespace WezomCms\Benefits\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

class BenefitsTypes extends Enum implements LocalizedEnum
{
    public const COMMON = 'common';
    public const ABOUT_1 = 'about_1';
    public const ABOUT_2 = 'about_2';
    public const PROGRESS = 'progress';

    /**
     * Get the default localization key
     *
     * @return string
     */
    public static function getLocalizationKey(): string
    {
        return 'cms-benefits::' . app('side') . '.benefits_types';
    }
}
