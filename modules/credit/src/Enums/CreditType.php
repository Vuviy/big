<?php

namespace WezomCms\Credit\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

class CreditType extends Enum implements LocalizedEnum
{
    public const INSTALLMENT = 'installment';
    public const CREDIT = 'credit';

    /**
     * Get the default localization key
     *
     * @return string
     */
    public static function getLocalizationKey(): string
    {
        return 'cms-credit::' . app('side') . '.credit_type';
    }
}
