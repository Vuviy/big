<?php

namespace WezomCms\Orders\Models;

use Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use WezomCms\Core\ExtendPackage\Translatable;
use WezomCms\Core\Traits\Model\GetForSelectTrait;
use WezomCms\Core\Traits\Model\ImageAttachable;
use WezomCms\Core\Traits\Model\OrderBySort;
use WezomCms\Core\Traits\Model\PublishedTrait;
use WezomCms\Orders\Contracts\Payment\HasCheckoutFieldsInterface;
use WezomCms\Orders\Contracts\Payment\OnlinePaymentInterface;

/**
 * \WezomCms\Orders\Models\Payment
 *
 * @property int $id
 * @property int $sort
 * @property bool $published
 * @property string|null $driver
 * @property string|null $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $bonus_type
 * @property-read \WezomCms\Orders\Models\PaymentTranslation|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection|\WezomCms\Orders\Models\PaymentTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|Payment listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Payment published()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment publishedWithSlug($slug, $slugField = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment sorting()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment translated()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereBonusType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereDriver($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment withTranslation()
 * @mixin \Eloquent
 * @mixin PaymentTranslation
 */
class Payment extends Model
{
    use Translatable;
    use ImageAttachable;
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
     * Associative array with custom drivers.
     *
     * @var array
     */
    protected static $drivers = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function deliveries()
    {
        return $this->belongsToMany(Delivery::class);
    }

    /**
     * @param  array $arguments
     * @param  string  $namespace
     * @return HasCheckoutFieldsInterface|OnlinePaymentInterface|null
     */
    public function makeDriver(array $arguments = [], $namespace = 'WezomCms\\Orders\\Drivers\\Payment')
    {
        if (!$this->driver) {
            return null;
        }

        return Cache::driver('array')
            ->rememberForever("payment-driver-{$this->driver}", function () use ($namespace, $arguments) {
                if (array_key_exists($this->driver, static::$drivers)) {
                    $fullClassName = static::$drivers[$this->driver];
                } else {
                    $fullClassName = (string)Str::of($namespace)
                        ->rtrim('\\')
                        ->append('\\', Str::studly($this->driver));
                }

                return class_exists($fullClassName) ? app($fullClassName, $arguments) : null;
            });
    }

    /**
     * Images configuration.
     *
     * @return array
     */
    public function imageSettings(): array
    {
        return ['image' => 'cms.orders.payment.image'];
    }

    /**
     * Add custom driver.
     *
     * @param  string  $name
     * @param $class
     */
    public static function addDriver(string $name, $class)
    {
        static::$drivers[$name] = $class;
    }
}
