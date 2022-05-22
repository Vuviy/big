<?php

namespace WezomCms\BuyOneClick\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use WezomCms\BuyOneClick\Models\BuyOneClick;
use WezomCms\Catalog\Models\Product;

class BuyOneClickFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BuyOneClick::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $product = Product::inRandomOrder()->first();

        return [
            'product_id' => $product ? $product->id : null,
            'count' => $this->faker->numberBetween(1, 15),
            'name' => $this->faker->name,
            'phone' => $this->faker->phoneNumber,
            'read' => $this->faker->boolean,
        ];
    }
}
