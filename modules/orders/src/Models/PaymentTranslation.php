<?php

namespace WezomCms\Orders\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * \WezomCms\Orders\Models\PaymentTranslation
 *
 * @property int $id
 * @property int $payment_id
 * @property string|null $name
 * @property string $locale
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\PaymentTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\PaymentTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\PaymentTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\PaymentTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\PaymentTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\PaymentTranslation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\PaymentTranslation wherePaymentId($value)
 * @mixin \Eloquent
 */
class PaymentTranslation extends Model
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
