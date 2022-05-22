<?php

namespace WezomCms\Catalog\ViewModels;

use Artesaos\SEOTools\Traits\SEOTools;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Spatie\SchemaOrg\ItemAvailability;
use Spatie\SchemaOrg\Schema;
use Spatie\ViewModels\ViewModel;
use WezomCms\Catalog\Contracts\ReviewRatingInterface;
use WezomCms\Catalog\Filter\Factory\UrlBuilderFactory;
use WezomCms\Catalog\Filter\Handlers\BrandHandler;
use WezomCms\Catalog\Filter\Handlers\ModelHandler;
use WezomCms\Catalog\Models\Brand;
use WezomCms\Catalog\Models\Category;
use WezomCms\Catalog\Models\Model;
use WezomCms\Catalog\Models\Product;
use WezomCms\Catalog\Models\ProductImage;
use WezomCms\Catalog\Models\Specifications\SpecValue;
use WezomCms\Core\Foundation\Helpers;
use WezomCms\Core\Traits\BreadcrumbsTrait;
use WezomCms\Core\Traits\LangSwitchingGenerator;
use WezomCms\Core\Traits\MicroDataTrait;
use WezomCms\Core\Traits\RecursiveBreadcrumbsTrait;
use WezomCms\Credit\Services\CreditService;
use WezomCms\ProductReviews\Models\ProductReview;

class ProductViewModel extends ViewModel
{
    use BreadcrumbsTrait;
    use LangSwitchingGenerator;
    use MicroDataTrait;
    use RecursiveBreadcrumbsTrait;
    use SEOTools;

    /**
     * @var Product
     */
    public $product;

    /**
     * @var Category|null
     */
    public $category;

    /**
     * @var Brand|null
     */
    public $brand;

    /**
     * @var bool
     */
    public $reviewsEnabled;

    /**
     * @var \Illuminate\Support\Collection
     */
    public $publishedReviews;

    /**
     * @var \Illuminate\Support\Collection
     */
    public $viewReviews;

    /**
     * @var \Illuminate\Support\Collection
     */
    public $selectedSpecValues;

    /**
     * @var \Illuminate\Support\Collection
     */
    public $accessories;

    /**
     * ProductViewModel constructor.
     * @param  Product  $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;

        $this->selectedSpecValues = $this->product->selectedSpecValues;

        $this->category = $this->product->category;

        $this->brand = config('cms.catalog.brands.enabled') ? $this->product->brand()->published()->first() : null;

        $this->setLangSwitchers($product, 'catalog.product', ['slug' => 'slug', 'id' => 'model.id']);

        $this->setSeo();

        $this->setBreadcrumbs();

        $this->setOpenGraph();

        $this->setMicroData();

        $this->publishedReviews = $this->product->publishedReviews;

        $this->viewReviews = ProductReview::getForFront($this->product->id);

        $this->accessories = $this->product->productAccessories()->published()->available()->fullSelection()->get();
    }

    /**
     * @return int
     */
    public function countReviews(): int
    {
        return $this->publishedReviews->count();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function specifications(): array
    {
        $result = [];

        // select related spec_values with specifications
        $specValues = $this->product->publishedSpecifications()
            ->get()
            ->sortBy('specification.sort');

        foreach (Helpers::groupByParentId($specValues, 'specification_id') as $items) {
            $specification = array_first($items)->specification;

            $result[$specification->name] = [
                'values' => $items,
            ];
        }

        if (config('cms.catalog.brands.enabled')) {
            if ($brand = $this->product->brand()->published()->first()) {
                $result[__('cms-catalog::site.Бренд')] = [
                    'values' => [$brand],
                ];
            }
        }


        if (config('cms.catalog.models.enabled')) {
            if ($model = $this->product->model()->published()->first()) {
                $result[__('cms-catalog::site.Модель')] = [
                    'values' => [$model],
                ];
            }
        }

        return Arr::sort($result, 'sort');
    }

    public function variations(): \Illuminate\Support\Collection
    {
        /** @var Product[]|\Illuminate\Database\Eloquent\Collection $allProducts */
        $allProducts = $this->product->combinedProducts()
            ->published()
            ->whereHas('primarySpecValues', function ($query) {
                $query->published()
                    ->whereHas('specification', published_scope());
            })
            ->with([
                'primarySpecValues' => function ($query) {
                    $query->published()->with(['specification' => published_scope()]);
                }])
            ->get()
            ->keyBy('id');

        if ($allProducts->isEmpty()) {
            return collect();
        }

        $groupedSpecValues = $allProducts->pluck('primarySpecValues')
            ->flatten()
            ->unique('id')
            ->groupBy('specification_id');

        foreach ($groupedSpecValues as $subId => $subItems) {
            foreach ($subItems as $subItem) {
                if ($allProducts->has($subItem->pivot->product_id)) {
                    $subItem->product = $allProducts->get($subItem->pivot->product_id);
                }
            }
        }

        return $groupedSpecValues->map(function ($items) {
            return $items->sortBy('sort');
        })
            ->sortBy(function ($items) {
                if($items->first()->specification){
                    return $items->first()->specification->sort;
                }
            });
    }

    /**
     * @return Collection|ProductImage[]|string[]
     */
    public function gallery()
    {
        return $this->product->gallery;
    }

    public function monthlyPayment()
    {
        return app(CreditService::class)->getMinimumPayment($this->product);
    }

    public function productRating()
    {
        return round($this->product->rating);
    }

    private function setSeo()
    {
        [$title, $h1, $description, $keywords] = $this->parseTemplate();

        $this->seo()
            ->setTitle($this->product->title ?: $title)
            ->setH1($this->product->h1 ?: $h1)
            ->setPageName($this->product->name)
            ->setDescription($this->product->description ?: $description)
            ->metatags()
            ->setKeywords($this->product->keywords ?: $keywords);
    }

    /**
     * @return array
     */
    private function parseTemplate(): array
    {
        $settings = settings('product.products', []);

        $replace = [
            '[name]' => $this->product->name,
            '[id]' => $this->product->id,
            '[cost]' => money($this->product->cost, true),
        ];

        $replace['[brand]'] = $this->brand ? $this->brand->name : '';

        if (config('cms.catalog.models.enabled')) {
            $model = $this->product->model;
            $replace['[model]'] = $model ? $model->name : '';
        }
        $from = array_keys($replace);
        $to = array_values($replace);

        $title = str_replace($from, $to, array_get($settings, 'title'));
        $h1 = str_replace($from, $to, array_get($settings, 'h1'));
        $description = str_replace($from, $to, array_get($settings, 'description'));
        $keywords = str_replace($from, $to, array_get($settings, 'keywords'));

        return [$title, $h1, $description, $keywords];
    }

    private function setBreadcrumbs()
    {
        // Breadcrumbs
        $this->addBreadcrumb(
            settings('categories.site.name', __('cms-catalog::site.catalog.Catalog')),
            route('catalog')
        );

        if ($this->category) {
            $this->addRecursiveBreadcrumbs($this->category);
        }

        if ($this->brand && $this->category) {
            $this->addBreadcrumb(
                $this->brand->name,
                UrlBuilderFactory::category($this->category)->buildUrlWith(BrandHandler::NAME, $this->brand->slug)
            );
        }

        $this->addBreadcrumb($this->product->name, $this->product->getFrontUrl());
    }

    private function setOpenGraph()
    {
        $openGraph = $this->seo()->opengraph();

        $this->product->getExistImages('big')->each(function (ProductImage $image) use ($openGraph) {
            $openGraph->addImage($image->getImageUrl('big'), $image->getImageSize('big'));
        });
    }

    private function setMicroData()
    {
        $schemaProduct = Schema::product()
            ->name($this->product->name)
            ->sku($this->product->id)
            ->description($this->seo()->metatags()->getDescription());

        if ($this->product->category) {
            $schemaProduct->category($this->product->category->name);
        }

        if ($this->brand) {
            $schemaProduct->brand(Schema::brand()->name($this->brand->name));
        }

        if ($this->product->imageExists()) {
            $schemaProduct->image($this->product->getImageUrl());
        }

        $offer = Schema::offer()
            ->price($this->product->cost)
            ->url($this->product->getFrontUrl())
            ->availability($this->product->available ? ItemAvailability::InStock : ItemAvailability::OutOfStock)
            ->priceCurrency(money()->code());

        $schemaProduct->offers($offer);

        // Add reviews
        if ($reviews = $this->publishedReviews) {
            /** @var \Illuminate\Support\Collection $reviews */
            $schemaReviews = $reviews->map(function ($review) {
                $schemaReview = Schema::review()
                    ->text($review->text)
                    ->datePublished($review->created_at->format('Y-m-d'))
                    ->author(Schema::person()->name($review->name));

                if ($review instanceof ReviewRatingInterface) {
                    $schemaReview->reviewRating(Schema::rating()->ratingValue($review->getRating()));
                }

                return $schemaReview;
            });
            $schemaProduct->reviews($schemaReviews->toArray());

            // Set product average rating.
            $averageRating = $reviews->avg(function ($review) {
                return $review instanceof ReviewRatingInterface ? $review->getRating() : 0;
            });

            if ($averageRating !== null && $reviews->count()) {
                $schemaProduct->aggregateRating(
                    Schema::aggregateRating()->ratingValue($averageRating)->reviewCount($reviews->count())
                );
            }
        }

        $this->renderMicroData($schemaProduct);
    }
}
