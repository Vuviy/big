<?php

namespace WezomCms\Newsletter\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use WezomCms\Newsletter\Models\Subscriber;

class SubscriberFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Subscriber::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'email' => $this->faker->email,
            'ip' => $this->faker->ipv4,
            'active' => $this->faker->boolean(80),
            'locale' => app()->getLocale(),
        ];
    }
}
