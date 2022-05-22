<?php

namespace WezomCms\News\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use WezomCms\News\Models\NewsTag;

class NewsTagFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = NewsTag::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->word;

        $data = [
            'published' => $this->faker->boolean(80),
        ];

        return array_merge($data, array_fill_keys(array_keys(app('locales')), [
            'name' => $name,
            'title' => $name,
            'h1' => $name,
        ]));
    }
}
