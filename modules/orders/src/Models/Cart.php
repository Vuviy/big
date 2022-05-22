<?php

namespace WezomCms\Orders\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * \WezomCms\Orders\Models\Cart
 *
 * @property int $id
 * @property string $hash
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property array|null $conditions
 * @property-read \Illuminate\Database\Eloquent\Collection|\WezomCms\Orders\Models\CartItem[] $items
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\Cart newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\Cart newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\Cart query()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\Cart whereConditions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\Cart whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\Cart whereHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\Cart whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\Cart whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Cart extends Model
{
    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'conditions' => '[]'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['hash'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['conditions' => 'array'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }
}
