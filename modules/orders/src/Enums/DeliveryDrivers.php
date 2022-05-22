<?php

namespace WezomCms\Orders\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;
use WezomCms\Orders\Drivers\Delivery\Courier;

final class DeliveryDrivers extends Enum implements LocalizedEnum
{
    public const COURIER = Courier::KEY;

    /**
     * Get the default localization key
     *
     * @return string
     */
    public static function getLocalizationKey(): string
    {
        return 'cms-orders::' . app('side') . '.delivery_drivers';
    }
}
