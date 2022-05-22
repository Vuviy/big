<?php

namespace WezomCms\Callbacks\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use WezomCms\Callbacks\Models\Callback;

class CallbackFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Callback::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'phone' => $this->faker->phoneNumber,
            'read' => $this->faker->boolean,
        ];
    }
}
