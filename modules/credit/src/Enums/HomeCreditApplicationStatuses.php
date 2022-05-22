<?php

namespace WezomCms\Credit\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class HomeCreditApplicationStatuses extends Enum implements LocalizedEnum
{
    public const APPROVED = 'APPROVED'; // ОДОБРЕНО
    public const PREAPPROVED = 'PREAPPROVED'; // ПРЕДВОРИТЕЛЬНО ОДОБРЕНО
    public const PREAPPROVED_NEW = 'PREAPPROVED_NEW'; // ПРЕДВОРИТЕЛЬНО ОДОБРЕНО (НОВЫЙ КЛИЕНТ)
    public const SIGNED = 'SIGNED'; // ПОДПИСАН
    public const SIGN_EDS = 'SIGN_EDS';
    public const CANCELLED = 'CANCELLED'; // ОТМЕНА
    public const PARTNER_CANCELLED = 'PARTNER_CANCELLED'; // ОТМЕНЕНО ПАРТНЕРОМ
    public const RESERVED = 'RESERVED'; // ТОВАР ЗАБРОНИРОВАН НА ОПРЕДЕЛЕННОЙ ТОРГОВОЙ ТОЧКЕ ПАРТНЕРА
    public const REJECTED = 'REJECTED'; // ОТКАЗАНО
    public const DELIVERED = 'DELIVERED'; // ДОГОВОР С КЛИЕНТОМ БЫЛ ПОДПИСАН И ТОВАР БЫЛ ВЫДАН КЛИЕНТУ
    public const PARTNER_CAN_SEND_STATUSES = [self::DELIVERED, self::PARTNER_CANCELLED, self::RESERVED];
}
