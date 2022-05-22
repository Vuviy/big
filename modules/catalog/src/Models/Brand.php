<?php

namespace WezomCms\Catalog\Models;

use Cviebrock\EloquentSluggable\Services\SlugService;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use WezomCms\Core\ExtendPackage\Translatable;
use WezomCms\Core\Foundation\Helpers;
use WezomCms\Core\Traits\Model\Filterable;
use WezomCms\Core\Traits\Model\ImageAttachable;
use WezomCms\Core\Traits\Model\OrderBySort;
use WezomCms\Core\Traits\Model\PublishedTrait;

/**
 * \WezomCms\Catalog\Models\Brand
 *
 * @property int $id
 * @property bool $published
 * @property string $slug
 * @property string|null $image
 * @property int $sort
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\WezomCms\Catalog\Models\Model[] $models
 * @property-read int|null $models_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\WezomCms\Catalog\Models\Product[] $products
 * @property-read int|null $products_count
 * @property-read \WezomCms\Catalog\Models\BrandTranslation $translation
 * @property-read \Illuminate\Database\Eloquent\Collection|\WezomCms\Catalog\Models\BrandTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Brand filter($input = array(), $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Brand findSimilarSlugs(string $attribute, array $config, string $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Brand listsTranslations($translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Brand newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Brand newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Brand notTranslatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Brand orWhereTranslation($translationField, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Brand orWhereTranslationLike($translationField, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Brand orderByTranslation($translationField, $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Brand paginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Brand published()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Brand publishedWithSlug($slug, $slugField = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Brand query()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Brand simplePaginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Brand sorting()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Brand translated()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Brand translatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Brand whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Brand whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Brand whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Brand whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Brand whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Brand whereLike($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Brand whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Brand whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Brand wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Brand whereTranslation($translationField, $value, $locale = null, $method = 'whereHas', $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Brand whereTranslationLike($translationField, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Brand whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Brand withTranslation()
 * @mixin \Eloquent
 * @mixin BrandTranslation
 */
class Brand extends EloquentModel
{
    use Translatable;
    use Filterable;
    use HasFactory;
    use ImageAttachable;
    use PublishedTrait;
    use OrderBySort;
    use Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['published', 'slug'];

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
     * @param  string|null  $search
     * @param  array  $criterion
     * @param  int  $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|Brand[]|array
     */
    public static function search(string $search = null, array $criterion = [], int $limit = 10)
    {
        $query = static::query();

        if ($search) {
            $query->whereTranslationLike('name', '%' . Helpers::escapeLike($search) . '%');
        }

        foreach ($criterion as $field => $value) {
            $query->where($field, $value);
        }

        return $query->paginate($limit);
    }

    /**
     * @return array
     */
    public function imageSettings(): array
    {
        return ['image' => 'cms.catalog.brands.images'];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function models()
    {
        return $this->hasMany(Model::class);
    }

    /**
     * @param  string|null  $search
     * @param  int  $limit
     * @return array
     */
    public static function getForSelect(string $search = null, int $limit = 10)
    {
        $query = Brand::query();

        if ($search) {
            $query->whereTranslationLike('name', '%' . Helpers::escapeLike($search) . '%');
        }

        return $query->paginate($limit)
            ->pluck('name', 'id')
            ->sort()
            ->toArray();
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
