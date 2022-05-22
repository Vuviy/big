<?php

namespace WezomCms\Orders\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use WezomCms\Core\ExtendPackage\Translatable;
use WezomCms\Core\Traits\Model\GetForSelectTrait;
use WezomCms\Core\Traits\Model\OrderBySort;

/**
 * \WezomCms\Orders\Models\OrderStatus
 *
 * @property int $id
 * @property int $sort
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $class
 * @property-read \Illuminate\Database\Eloquent\Collection|\WezomCms\Orders\Models\Order[] $orders
 * @property-read \Illuminate\Database\Eloquent\Collection|\WezomCms\Orders\Models\OrderStatusTranslation[] $translations
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\OrderStatus listsTranslations($translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\OrderStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\OrderStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\OrderStatus notTranslatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\OrderStatus orWhereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\OrderStatus orWhereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\OrderStatus orderByTranslation($key, $sortmethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\OrderStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\OrderStatus sorting()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\OrderStatus translated()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\OrderStatus translatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\OrderStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\OrderStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\OrderStatus whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\OrderStatus whereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\OrderStatus whereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\OrderStatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Orders\Models\OrderStatus withTranslation()
 * @mixin \Eloquent
 * @mixin OrderStatusTranslation
 */
class OrderStatus extends Model
{
    use Translatable;
    use GetForSelectTrait;
    use HasFactory;
    use OrderBySort;

    public const NEW = 1;
    public const DONE = 2;
    public const CANCELED = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['color'];


    /**
     * Names of the fields being translated in the "Translation" model.
     *
     * @var array
     */
    protected $translatedAttributes = ['name'];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translation'];

    /**
     * @return OrderStatus
     */
    public static function newStatus()
    {
        return static::find(static::NEW);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'status_id');
    }

    /**
     * @return string
     */
    public function getClassAttribute()
    {
        switch ($this->id) {
            case static::DONE:
                return 'is-made';
            case static::CANCELED:
                return 'is-cancel';
            case static::NEW:
            default:
                return 'is-process';
        }
    }
}
