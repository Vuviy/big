<?php

namespace WezomCms\Orders\Models;

use Illuminate\Database\Eloquent\Model;
use Lang;
use WezomCms\Catalog\Models\Product;
use WezomCms\Core\Image\ImageHandler;

/**
 * \WezomCms\Orders\Models\OrderItem
 *
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property float $quantity
 * @property float $price
 * @property float $purchase_price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int $discount
 * @property-read string $name
 * @property-read string $quantity_with_unit
 * @property-read string $unit
 * @property-read float $whole_price
 * @property-read float $whole_purchase_price
 * @property-read \WezomCms\Orders\Models\Order $order
 * @property-read \WezomCms\Catalog\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\OrderItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\OrderItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\OrderItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\OrderItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\OrderItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\OrderItem whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\OrderItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\OrderItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\OrderItem wherePurchasePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\OrderItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\OrderItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OrderItem extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['product_id', 'quantity', 'price', 'purchase_price', 'product_cost', 'product_old_cost', 'product_sale'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->product ? $this->product->name : __('cms-orders::admin.orders.Product deleted');
    }

    /**
     * @param  string|null  $size
     * @param  string|null  $field
     * @return string|null
     */
    public function getImageUrl(string $size = null, string $field = 'image')
    {
        return $this->product
            ? $this->product->getImageUrl($size, $field)
            : url(ImageHandler::noImage(50, 50));
    }

    /**
     * @return string
     */
    public function getFrontUrl()
    {
        return $this->product ? $this->product->getFrontUrl() : '#';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return int
     */
    public function getDiscountAttribute()
    {
        return $this->price - $this->purchase_price;
    }

    /**
     * @return float
     */
    public function getWholePriceAttribute()
    {
        return $this->quantity * $this->price;
    }

    /**
     * @return float
     */
    public function getWholePurchasePriceAttribute()
    {
        return $this->quantity * $this->purchase_price;
    }

    /**
     * @return string
     */
    public function getQuantityWithUnitAttribute()
    {
        return $this->quantity . ' ' . $this->unit;
    }

    /**
     * @return string
     */
    public function getUnitAttribute()
    {
        return $this->product ? $this->product->unit() : Lang::get('cms-orders::' . app('side') . '.pieces');
    }
/*
    /**
     * @return float
     */
    public function getWholeProductCostAttribute()
    {
        return $this->quantity * $this->product_cost;
    }

    /**
     * @return float
     */
    public function getWholeProductOldCostAttribute()
    {
        return $this->quantity * $this->product_old_cost;
    }
}
