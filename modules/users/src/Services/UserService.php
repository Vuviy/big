<?php


namespace WezomCms\Users\Services;

use WezomCms\Users\Dto\UserDto;
use WezomCms\Users\Models\User;

class UserService
{

    public function updatePersonalInfo(User $user, UserDto $userDto) : void
    {
        $user->name     = $userDto->getName();
        $user->surname  = $userDto->getSurname();
        $user->birthday = $userDto->getBirthday();

        $user->save();
    }

    public function updateContactInfo(User $user, UserDto $userDto) : void
    {
        $user->phone         = $userDto->getPhone();
        $user->email         = $userDto->getEmail();
        $user->communication = $userDto->getCommunication();

        $user->save();
    }

}
