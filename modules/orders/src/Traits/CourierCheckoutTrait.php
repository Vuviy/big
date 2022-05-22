<?php

namespace WezomCms\Orders\Traits;

use Auth;
use Illuminate\Support\Arr;
use WezomCms\Orders\Models\UserAddress;

trait CourierCheckoutTrait
{
    /**
     * @param $value
     * @param $name
     */
    public function updatedDeliveryData($value, $name)
    {
        if ($name === 'saved_address_id') {
            // If selected address from personal address book - fill fields.
            if ($value && $user = Auth::user()) {
                /** @var UserAddress|null $address */
                if ($address = $user->addresses()->find($value)) {
                    $this->fillDeliveryDataFromUserAddress($address);
                }
            } else {
                // Reset fields
                $this->deliveryData['locality_id'] = null;
                $this->deliveryData['street'] = null;
                $this->deliveryData['house'] = null;
                $this->deliveryData['room'] = null;
                $this->deliveryData['save_address'] = true;
            }
        }
    }

    public function updatedDeliveryId()
    {
        $this->autocompleteDeliveryAddress();
    }

    protected function autocompleteDeliveryAddress()
    {
        if (array_get($this->deliveryData, 'saved_address_id') === null && $user = Auth::user()) {
            /** @var UserAddress|null $savedAddress */
            $savedAddress = $user->addresses()->where('primary', true)->first();

            if ($savedAddress) {
                $this->fillDeliveryDataFromUserAddress($savedAddress);
            }
        }
    }

    /**
     * @param  UserAddress  $address
     */
    protected function fillDeliveryDataFromUserAddress(UserAddress $address)
    {
        $this->deliveryData['saved_address_id'] = $address->id;
        $this->deliveryData['locality_id'] = $address->locality_id;
        $this->deliveryData['street'] = $address->street;
        $this->deliveryData['house'] = $address->house;
        $this->deliveryData['room'] = $address->room;
        $this->deliveryData['save_address'] = false;
    }

    protected function afterCreationOrder()
    {
        if (array_get($this->deliveryData, 'save_address') && $user = Auth::user()) {
            /** @var \WezomCms\Users\Models\User $user */
            $user->addresses()->create(Arr::only($this->deliveryData, ['locality_id', 'street', 'house', 'room']));
        }
    }
}
