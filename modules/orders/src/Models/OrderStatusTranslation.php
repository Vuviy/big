<?php

namespace WezomCms\Orders\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * \WezomCms\Orders\Models\OrderStatusTranslation
 *
 * @property int $id
 * @property int $order_status_id
 * @property string|null $name
 * @property string $locale
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\OrderStatusTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\OrderStatusTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\OrderStatusTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\OrderStatusTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\OrderStatusTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\OrderStatusTranslation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\OrderStatusTranslation whereOrderStatusId($value)
 * @mixin \Eloquent
 */
class OrderStatusTranslation extends Model
{
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
    protected $fillable = ['name'];
}
