<?php

namespace WezomCms\Users\Dto;

use Auth;

class UserAddressesDto
{
    public $localityId;
    public $userID;
    public $primary;
    public $street;
    public $house;
    public $room;

    public static function dataRequest(array $data): self
    {
        $instance = new self();

        $instance->localityId = $data['locality_id'] ?? null;
        $instance->userID = Auth::id();
        $instance->primary = $data['primary'] ?? false;
        $instance->street = $data['street'] ?? null;
        $instance->house = $data['house'] ?? null;
        $instance->room = $data['room'] ?? null;

        return $instance;
    }

    /**
     * @return mixed
     */
    public function getLocalityId()
    {
        return $this->localityId;
    }

    /**
     * @return mixed
     */
    public function getUserID()
    {
        return $this->userID;
    }

    /**
     * @return mixed
     */
    public function getPrimary()
    {
        return $this->primary;
    }

    /**
     * @return mixed
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @return mixed
     */
    public function getHouse()
    {
        return $this->house;
    }

    /**
     * @return mixed
     */
    public function getRoom()
    {
        return $this->room;
    }
}
