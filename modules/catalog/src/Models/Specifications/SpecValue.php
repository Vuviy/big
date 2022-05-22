<?php

namespace WezomCms\Catalog\Models\Specifications;

use Cviebrock\EloquentSluggable\Services\SlugService;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use WezomCms\Catalog\Models\Product;
use WezomCms\Core\ExtendPackage\Translatable;
use WezomCms\Core\Traits\Model\OrderBySort;
use WezomCms\Core\Traits\Model\PublishedTrait;

/**
 * Class SpecValue
 *
 * @property int $id
 * @property bool $published
 * @property int $sort
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string $locale
 * @property string $slug
 * @property string $color
 * @property string $name
 * @method published()
 * @property int $specification_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\WezomCms\Catalog\Models\Product[] $products
 * @property-read \WezomCms\Catalog\Models\Specifications\Specification $specification
 * @property-read \Illuminate\Database\Eloquent\Collection|\WezomCms\Catalog\Models\Specifications\SpecValueTranslation[] $translations
 * @method static Builder|SpecValue findSimilarSlugs($attribute, $config, $slug)
 * @method static Builder|SpecValue listsTranslations($translationField)
 * @method static Builder|SpecValue newModelQuery()
 * @method static Builder|SpecValue newQuery()
 * @method static Builder|SpecValue notTranslatedIn($locale = null)
 * @method static Builder|SpecValue orWhereTranslation($key, $value, $locale = null)
 * @method static Builder|SpecValue orWhereTranslationLike($key, $value, $locale = null)
 * @method static Builder|SpecValue orderByTranslation($key, $sortmethod = 'asc')
 * @method static Builder|SpecValue query()
 * @method static Builder|SpecValue sorting()
 * @method static Builder|SpecValue translated()
 * @method static Builder|SpecValue translatedIn($locale = null)
 * @method static Builder|SpecValue whereCreatedAt($value)
 * @method static Builder|SpecValue whereId($value)
 * @method static Builder|SpecValue whereSlug($value)
 * @method static Builder|SpecValue whereSort($value)
 * @method static Builder|SpecValue whereSpecificationId($value)
 * @method static Builder|SpecValue wherePublished($value)
 * @method static Builder|SpecValue whereTranslation($key, $value, $locale = null)
 * @method static Builder|SpecValue whereTranslationLike($key, $value, $locale = null)
 * @method static Builder|SpecValue whereUpdatedAt($value)
 * @method static Builder|SpecValue withTranslation()
 * @mixin \Eloquent
 * @mixin SpecValueTranslation
 */
class SpecValue extends Model
{
    use HasFactory;
    use Translatable;
    use Sluggable;
    use PublishedTrait;
    use OrderBySort;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['published', 'sort', 'slug', 'color'];

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function specification()
    {
        return $this->belongsTo(Specification::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_specifications');
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    /**
     * @param $value
     */
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = SlugService::createSlug($this, 'slug', (string) $value);
    }
}
