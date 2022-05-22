<?php

namespace WezomCms\Catalog\Models;

use Cache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * Class ProductSpecification
 * @property int $id
 * @property int $product_id
 * @property int $spec_id
 * @property int $spec_value_id
 */
class ProductSpecification extends EloquentModel
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['product_id', 'spec_id', 'spec_value_id'];

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted()
    {
        static::saved(function () {
            if (method_exists(Cache::getStore(), 'tags')) {
                Cache::tags(ProductSpecification::class)->flush();
            }
        });

        static::deleted(function () {
            if (method_exists(Cache::getStore(), 'tags')) {
                Cache::tags(ProductSpecification::class)->flush();
            }
        });
    }
}
