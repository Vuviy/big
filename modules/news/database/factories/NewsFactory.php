<?php

namespace WezomCms\News\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use WezomCms\News\Models\News;

class NewsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = News::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->realText(50);

        $data = [
            'published_at' => $this->faker->dateTimeBetween('-10 days', 'now'),
        ];

        return array_merge($data, array_fill_keys(array_keys(app('locales')), [
            'published' => $this->faker->boolean(80),
            'name' => $name,
            'h1' => $name,
            'title' => $name,
            'text' => $this->faker->realText(1000),
        ]));
    }
}
