<?php

namespace WezomCms\Users\Services;

use WezomCms\Users\Dto\UserAddressesDto;
use WezomCms\Orders\Models\UserAddress;

class UserAddressesService
{

    public function createOrUpdate(UserAddressesDto $userAddressesDto, $id): UserAddress
    {
        return UserAddress::updateOrCreate(
            ['id' => $id, 'user_id' => $userAddressesDto->getUserID()],
            [
                'locality_id' => $userAddressesDto->getLocalityId(),
                'street' => $userAddressesDto->getStreet(),
                'house' => $userAddressesDto->getHouse(),
                'room' => $userAddressesDto->getRoom(),
                'primary' => $userAddressesDto->getPrimary(),
                'user_id' => $userAddressesDto->getUserID()
            ]);
    }

    public function deleteAddress(int $id): void
    {
        UserAddress::destroy($id);
    }
}
