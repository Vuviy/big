<?php

namespace WezomCms\Faq\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use WezomCms\Faq\Models\FaqGroup;

class FaqGroupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FaqGroup::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $data = [
            'sort' => $this->faker->randomNumber(4),
            'published' => $this->faker->boolean(80),
        ];

        return array_merge($data, array_fill_keys(array_keys(app('locales')), [
            'name' => $this->faker->realText(25),
        ]));
    }
}
