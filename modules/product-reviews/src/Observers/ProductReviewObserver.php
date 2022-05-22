<?php

namespace WezomCms\ProductReviews\Observers;

use WezomCms\Catalog\Models\Product;
use WezomCms\ProductReviews\Models\ProductReview;

/**
 * Class ProductObserver
 * @package WezomCms\ProductReviews\Observers
 */
class ProductReviewObserver
{
    /**
     * @param  ProductReview  $review
     */
    public function saved(ProductReview $review)
    {
        $review->load([
            'product' => function ($query) {
                $query->withTrashed();
            }
        ]);

        if ($review->product) {
            $this->calculateRating($review->product);
        }
    }

    /**
     * @param  ProductReview  $review
     */
    public function deleted(ProductReview $review)
    {
        $review->load([
            'product' => function ($query) {
                $query->withTrashed();
            }
        ]);

        if ($review->product) {
            $this->calculateRating($review->product);
        }
    }

    /**
     * @param  Product  $product
     */
    protected function calculateRating(Product $product)
    {
        $rating = $product->publishedReviews()->root()->avg('rating');

        $product->rating = $rating ?: 0;

        $product->save();
    }
}
