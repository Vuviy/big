<?php

namespace WezomCms\Users\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use WezomCms\Users\Models\User;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->firstName,
            'surname' => $this->faker->lastName,
            'phone' => $this->faker->numerify('+7 (###) ### ## ##'),
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'registered_through' => User::EMAIL,
            'password' => '',
            'active' => $this->faker->boolean,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
