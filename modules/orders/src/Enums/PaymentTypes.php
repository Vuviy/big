<?php

namespace WezomCms\Orders\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class PaymentTypes extends Enum implements LocalizedEnum
{
    public const CASH = 'cash';
    public const CLOUD_PAYMENT = 'cloud-payment';

    /**
     * Get the default localization key
     *
     * @return string
     */
    public static function getLocalizationKey(): string
    {
        return 'cms-orders::' . app('side') . '.payment_types';
    }
}
