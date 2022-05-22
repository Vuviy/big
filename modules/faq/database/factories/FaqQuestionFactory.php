<?php

namespace WezomCms\Faq\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use WezomCms\Faq\Models\FaqGroup;
use WezomCms\Faq\Models\FaqQuestion;

class FaqQuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FaqQuestion::class;

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

        if (config('cms.faq.faq.use_groups')) {
            $group = FaqGroup::inRandomOrder()->first();
            $data['faq_group_id'] = $group ? $group->id : null;
        }

        return array_merge($data, array_fill_keys(array_keys(app('locales')), [
            'question' => $this->faker->realText(50),
            'answer' => $this->faker->realText($this->faker->numberBetween(100, 250)),
        ]));
    }
}
