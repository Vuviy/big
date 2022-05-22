<?php

namespace WezomCms\Pages\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use WezomCms\Pages\Models\Page;

class PageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Page::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->realText(25);

        return array_fill_keys(array_keys(app('locales')), [
            'published' => $this->faker->boolean(80),
            'name' => $name,
            'h1' => $name,
            'title' => $name,
            'text' => $this->faker->realText(500),
        ]);
    }
}
