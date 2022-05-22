<?php

namespace WezomCms\Slider\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use WezomCms\Slider\Models\Slide;

class SlideFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Slide::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $sliders = config('cms.slider.slider.sliders');

        $data = [
            'open_in_new_tab' => $this->faker->boolean,
            'slider' => $this->faker->randomKey($sliders),
        ];

        return array_merge($data, array_fill_keys(array_keys(app('locales')), [
            'published' => $this->faker->boolean(80),
            'name' => $this->faker->realText(50),
            'url' => $this->faker->url,
        ]));
    }
}
