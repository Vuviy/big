<?php

namespace WezomCms\OurTeam\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use WezomCms\OurTeam\Models\Employee;

class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $data = [
            'published' => $this->faker->boolean(80),
        ];

        return array_merge($data, array_fill_keys(array_keys(app('locales')), [
            'name' => $this->faker->realText(50),
            'position' => $this->faker->realText(50),
            'description' => $this->faker->realText(50),
        ]));
    }
}
