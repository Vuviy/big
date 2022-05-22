<?php
namespace WezomCms\Users\Dto;

class UserDto
{
    public $name;
    public $surname;
    public $birthday;
    public $phone;
    public $email;
    public $communication;

    public static function dataRequest(array $data): self
    {
        $instance = new self();

        $instance->name          = $data['name']          ?? null;
        $instance->surname       = $data['surname']       ?? null;
        $instance->birthday      = $data['birthday']      ?? null;
        $instance->phone         = $data['phone']         ?? null;
        $instance->email         = $data['email']         ?? null;
        $instance->communication = $data['communication'] ?? null;

        return $instance;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @return mixed
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getCommunication()
    {
        return $this->communication;
    }


}
