<?php

namespace WezomCms\Orders\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status_id' => 'required|exists:order_statuses,id',
            'payment_id' => 'required|exists:payments,id',
            'payed' => 'required|bool',
            'delivery_id' => 'required|int|exists:deliveries,id',

            'client.surname' => 'nullable|string|max:255',
            'client.name' => 'nullable|string|max:255',
            'client.patronymic' => 'nullable|string|max:255',
            'client.email' => 'nullable|email|max:255',
            'client.phone' => 'nullable|string|max:255',
            'client.comment' => 'nullable|string|max:65535',
            'client.communications' => 'nullable|array',
            'client.communications.*' => 'nullable|string|exists:communications,driver',

            'deliveryInformation.locality_id' => 'required|int|exists:localities,id',
            'deliveryInformation.delivery_cost' => 'required|numeric|min:0',
            'deliveryInformation.street' => 'nullable|string|max:50',
            'deliveryInformation.house' => 'nullable|string|max:10',
            'deliveryInformation.room' => 'nullable|int|min:0',
            'deliveryInformation.ttn' => 'nullable|string|max:100',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'status_id' => __('cms-orders::admin.orders.Status'),
            'payment_id' => __('cms-orders::admin.orders.Payment method'),
            'payed' => __('cms-orders::admin.orders.Payed'),
            'delivery_id' => __('cms-orders::admin.orders.Delivery method'),

            'client.surname' => __('cms-orders::admin.orders.Surname'),
            'client.name' => __('cms-orders::admin.orders.Name'),
            'client.patronymic' => __('cms-orders::admin.orders.Patronymic'),
            'client.email' => __('cms-orders::admin.orders.Email'),
            'client.phone' => __('cms-orders::admin.orders.Phone'),
            'client.comment' => __('cms-orders::admin.orders.Comment'),
            'client.communications' => __('cms-orders::admin.communication.Preferred communication methods'),

            'deliveryInformation.locality_id' => __('cms-orders::admin.orders.Locality'),
            'deliveryInformation.delivery_cost' => __('cms-orders::admin.orders.Delivery cost'),
            'deliveryInformation.street' => __('cms-orders::admin.courier.Street'),
            'deliveryInformation.house' => __('cms-orders::admin.courier.House'),
            'deliveryInformation.room' => __('cms-orders::admin.courier.Room'),
            'deliveryInformation.ttn' => __('cms-orders::admin.orders.TTN'),
        ];
    }
}
