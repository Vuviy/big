<?php


namespace Database\Seeders\Fake;

use Illuminate\Database\Seeder;
use WezomCms\Catalog\Models\Category;
use WezomCms\Catalog\Models\CategorySpecification;
use WezomCms\Catalog\Models\Model;
use WezomCms\Catalog\Models\Product;
use WezomCms\Catalog\Models\ProductSpecification;
use WezomCms\Catalog\Models\Specifications\Specification;
use WezomCms\Catalog\Models\Specifications\SpecValue;
use WezomCms\Core\Foundation\Helpers;
use WezomCms\ProductLabels\Models\ProductLabel;
use WezomCms\ProductLabels\Models\ProductProductLabel;
use WezomCms\ProductReviews\Models\ProductReview;
use WezomCms\ProductReviews\ProductReviewsServiceProvider;
use WezomCms\ProductLabels\ProductLabelsServiceProvider;

class CatalogSeeder extends Seeder
{
    public function run()
    {
        if (!Category::count()) {
            Category::factory()->count(8)->create()->each(function ($rootCategory) {
                Category::factory()->count(random_int(3, 5))->create([
                    'parent_id' => $rootCategory->id
                ])->each(function ($category) {
                    Category::factory()->count(random_int(5, 8))->create([
                        'parent_id' => $category->id
                    ]);
                });
            });
        }

        if (!Model::count()) {
            Model::factory()->count(20)->create();
        }

        if (!Product::count()) {
            Product::factory()->count(2000)->create();
        }

        if (Specification::count() <= 1) {
            Specification::factory()->count(50)->create()->each(function ($specification) {
                SpecValue::factory()->count(random_int(4, 12))->create([
                    'specification_id' => $specification->id
                ]);
            });
        }

        $specifications = Specification::has('specValues')->get();

        if (!CategorySpecification::count()) {
            $categorySpecifications = [];
            foreach (Category::cursor() as $category) {
                foreach ($specifications->random(random_int(6, 10)) as $specification) {
                    $categorySpecifications[] = [
                        'category_id' => $category->id,
                        'specification_id' => $specification->id,
                    ];
                }
            }
            CategorySpecification::insert($categorySpecifications);
        }

        if (!ProductSpecification::count()) {
            $productSpecifications = [];
            foreach (CategorySpecification::with('category.products', 'specification.specValues')->cursor() as $categorySpecification) {
                foreach ($categorySpecification->category->products as $product) {
                    $productSpecifications[] = [
                        'product_id' => $product->id,
                        'spec_id' => $categorySpecification->specification_id,
                        'spec_value_id' => $categorySpecification->specification->specValues->random()->id,
                    ];
                }
            }
            foreach (array_chunk($productSpecifications, 10000) as $chunk) {
                ProductSpecification::insert($chunk);
            }
        }

        $labelsLoaded = Helpers::providerLoaded(ProductLabelsServiceProvider::class);
        $reviewsLoaded = Helpers::providerLoaded(ProductReviewsServiceProvider::class);

        if ($labelsLoaded && !ProductLabel::count()) {
            ProductLabel::factory()->count(6)->create()->each(function ($label) {
                foreach (Product::inRandomOrder()->limit(150)->get() as $product) {
                    ProductProductLabel::create([
                        'product_label_id' => $label->id,
                        'product_id' => $product->id,
                    ]);
                }
            });
        }

        if ($reviewsLoaded && !ProductReview::count()) {
            foreach (Product::inRandomOrder()->limit(20)->get() as $product) {
                ProductReview::factory()->count(6)->create([
                    'product_id' => $product->id,
                ])->each(function ($parent) use ($product) {
                    ProductReview::factory()->count(random_int(2, 8))->create([
                        'product_id' => $product->id,
                        'parent_id' => $parent->id
                    ]);
                });
            }
        }
    }
}
