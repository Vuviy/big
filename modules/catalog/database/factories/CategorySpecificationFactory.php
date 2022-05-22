<?php

namespace WezomCms\Catalog\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use WezomCms\Catalog\Models\Category;
use WezomCms\Catalog\Models\Specifications\Specification;
use WezomCms\Catalog\Models\CategorySpecification;

class CategorySpecificationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CategorySpecification::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws \Exception
     */
    public function definition()
    {
        /** @var Category $category */
        $category = Category::whereDoesntHave('children')->inRandomOrder()->first();

        /** @var Specification $specification */
        $specification = Specification::inRandomOrder()->first();

        return [
            'category_id' => $category->id,
            'specification_id' => $specification->id,
        ];
    }
}
