<?php

namespace WezomCms\Menu\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use WezomCms\Menu\Models\Menu;

class MenuFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Menu::class;

    /**
     * Define the model's default state.
     *
     * @param  array  $attributes
     * @return array
     */
    public function definition(array $attributes = [])
    {
        $data = [
            'sort' => $this->faker->randomNumber(5),
            'group' => array_get($attributes, 'group', array_rand(config('cms.menu.menu.groups', []))),
            'parent_id' => array_get($attributes, 'parent_id'),
        ];

        return array_merge($data, array_fill_keys(array_keys(app('locales')), [
            'name' => $this->faker->word,
            'url' => $this->faker->url,
            'published' => $this->faker->boolean(80),
        ]));
    }
}
