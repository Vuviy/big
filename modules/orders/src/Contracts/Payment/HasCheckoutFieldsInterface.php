<?php

namespace WezomCms\Orders\Contracts\Payment;

use WezomCms\Orders\Http\Livewire\Checkout;
use WezomCms\Orders\Models\Order;
use WezomCms\Orders\Models\OrderPaymentInformation;

interface HasCheckoutFieldsInterface
{
    /**
     * @param  Checkout  $checkout
     * @return mixed
     */
    public function renderFormInputs(Checkout $checkout);

    /**
     * Get validation rules.
     *
     * @return array
     */
    public function getValidationRules(): array;

    /**
     * Fill database storage.
     *
     * @param  OrderPaymentInformation  $storage
     * @param  array  $data
     */
    public function fillStorage(OrderPaymentInformation $storage, array $data);

    /**
     * @param  OrderPaymentInformation  $storage
     * @param  Order|null  $order
     * @return mixed
     */
    public function renderAdminFormInputs(OrderPaymentInformation $storage, ?Order $order = null);

    /**
     * @param  OrderPaymentInformation  $storage
     * @param  Order|null  $order
     * @return mixed
     */
    public function renderAdminFormData(OrderPaymentInformation $storage, ?Order $order = null);
}
