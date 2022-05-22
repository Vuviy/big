<?php

namespace WezomCms\Credit\Contracts;

use WezomCms\Orders\Models\OrderPaymentInformation;

interface CreditBankSendsStatusesToBankInterface
{
    /**
     * Рендерит кнопки в админ панели для изменения статуса в банке
     */
    public function renderAdminFormStatusChangingButtons(OrderPaymentInformation $orderPaymentInformation);

    /**
     * Отправляет статус в банк
     */
    public static function sendStatusToBank(OrderPaymentInformation $orderPaymentInformation, string $status);
}
