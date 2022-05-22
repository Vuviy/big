<?php

namespace WezomCms\Catalog\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use WezomCms\Catalog\Models\Brand;
use WezomCms\Catalog\Models\Category;
use WezomCms\Catalog\Models\Model;
use WezomCms\Catalog\Models\Product;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        /** @var Brand $brand */
        if (config('cms.catalog.brands.enabled')) {
            $brand = Brand::inRandomOrder()->first();
            $model = $brand ? $brand->models()->inRandomOrder()->first() : null;
        } else {
            $model = Model::inRandomOrder()->first();
        }

        $name = $this->faker->realText(50);

        $category = Category::doesntHave('children')->inRandomOrder()->first();

        $cost = $this->faker->numberBetween(0, 9999);
        $sale = $this->faker->boolean;

        $data = [
            'published' => true,
            'category_id' => $category ? $category->id : null,
            'cost' => $cost,
            'sale' => $sale,
            'old_cost' => $sale ? $this->faker->numberBetween($cost, 9999) : 0,
            'brand_id' => isset($brand) ? $brand->id : null,
            'model_id' => isset($model) ? $model->id : null,
            'novelty' => $this->faker->boolean,
            'popular' => $this->faker->boolean,
            'videos' => [$this->faker->url, $this->faker->url, $this->faker->url],
        ];

        return array_merge($data, array_fill_keys(array_keys(app('locales')), [
            'name' => $name,
            'text' => $this->faker->realText($this->faker->numberBetween(250, 500)),
            'title' => $name,
            'h1' => $name,
        ]));
    }
}
