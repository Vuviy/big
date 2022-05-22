<?php

namespace WezomCms\Contacts\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use WezomCms\Contacts\Models\Contact;

class ContactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contact::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'read' => $this->faker->boolean(80),
            'name' => $this->faker->name,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->email,
            'city' => $this->faker->city,
            'message' => $this->faker->realText($this->faker->numberBetween(100, 250)),
        ];
    }
}
