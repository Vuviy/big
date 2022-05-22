<?php

namespace WezomCms\Orders\Models;

use Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use WezomCms\Core\ExtendPackage\Translatable;
use WezomCms\Core\Traits\Model\GetForSelectTrait;
use WezomCms\Core\Traits\Model\OrderBySort;
use WezomCms\Core\Traits\Model\PublishedTrait;
use WezomCms\Orders\Contracts\DeliveryDriverInterface;

/**
 * \WezomCms\Orders\Models\Delivery
 *
 * @property int $id
 * @property int $sort
 * @property bool $published
 * @property string|null $driver
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\WezomCms\Orders\Models\Payment[] $payments
 * @property-read \Illuminate\Database\Eloquent\Collection|\WezomCms\Orders\Models\DeliveryTranslation[] $translations
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery listsTranslations($translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery notTranslatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery orWhereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery orWhereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery orderByTranslation($key, $sortmethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery published()
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery publishedWithSlug($slug, $slugField = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery query()
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery sorting()
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery translated()
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery translatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery whereDriver($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery whereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery whereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Delivery withTranslation()
 * @mixin \Eloquent
 * @mixin DeliveryTranslation
 */
class Delivery extends Model
{
    use Translatable;
    use GetForSelectTrait;
    use PublishedTrait;
    use OrderBySort;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['published', 'sort'];

    /**
     * Names of the fields being translated in the "Translation" model.
     *
     * @var array
     */
    protected $translatedAttributes = ['name'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['published' => 'bool'];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translation'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function payments()
    {
        return $this->belongsToMany(Payment::class);
    }

    /**
     * @param  array  $arguments
     * @param  string  $namespace
     * @return DeliveryDriverInterface|null
     */
    public function makeDriver(
        array $arguments = [],
        string $namespace = 'WezomCms\\Orders\\Drivers\\Delivery'
    ): ?DeliveryDriverInterface {
        if (!$this->driver) {
            return null;
        }

        return Cache::driver('array')
            ->rememberForever("delivery-driver-{$this->driver}", function () use ($namespace, $arguments) {
                $fullClassName = (string)Str::of($namespace)
                    ->rtrim('\\')
                    ->append('\\', Str::studly($this->driver));

                return class_exists($fullClassName) ? app($fullClassName, $arguments) : null;
            });
    }
}
