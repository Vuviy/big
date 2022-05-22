<?php

namespace WezomCms\Branches\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use WezomCms\Branches\Models\Branch;

class BranchFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Branch::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $data = [
            'published' => $this->faker->boolean(80),
            'email' => $this->faker->email,
            'phones' => [$this->faker->phoneNumber, $this->faker->phoneNumber],
        ];

        return array_merge($data, array_fill_keys(array_keys(app('locales')), [
            'name' => $this->faker->realText(50),
            'address' => $this->faker->address,
        ]));
    }
}
