<?php

namespace WezomCms\Catalog\Models;

use Greabock\Tentacles\EloquentTentacle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use WezomCms\Catalog\Filter\Contracts\StorageInterface;
use WezomCms\Catalog\Models\Specifications\Specification;
use WezomCms\Catalog\Models\Specifications\SpecValue;
use WezomCms\Catalog\Traits\ProductFlagsTrait;
use WezomCms\Catalog\Traits\ProductImageTrait;
use WezomCms\Catalog\Traits\PurchasedProductTrait;
use WezomCms\Core\ExtendPackage\Translatable;
use WezomCms\Core\Foundation\Helpers;
use WezomCms\Core\Traits\Model\Filterable;
use WezomCms\Core\Traits\Model\OrderBySort;
use WezomCms\Core\Traits\Model\PublishedTrait;
use WezomCms\Favorites\Contracts\Favorable;
use WezomCms\Favorites\Traits\FavorableTrait;
use WezomCms\Orders\Contracts\PurchasedProductInterface;

/**
 * WezomCms\Catalog\Models\Product
 *
 * @property int $id
 * @property bool $published
 * @property string|null $group_key
 * @property float $cost
 * @property float $old_cost
 * @property array $videos
 * @property bool $novelty
 * @property bool $popular
 * @property bool $sale
 * @property \Illuminate\Support\Carbon|null $expires_at
 * @property int|null $discount_percentage
 * @property bool $available
 * @property int $sort
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $brand_id
 * @property int|null $model_id
 * @property int|null $category_id
 * @property int|null $color_id
 * @property int $rating
 * @property-read \WezomCms\Catalog\Models\Brand|null $brand
 * @property-read \WezomCms\Catalog\Models\Category|null $category
 * @property-read \WezomCms\Catalog\Models\Specifications\SpecValue $color
 * @property-read \Illuminate\Database\Eloquent\Collection|\WezomCms\Catalog\Models\Product[] $combinedProducts
 * @property-read int|null $combined_products_count
 * @property-read string $flag_color
 * @property-read string $flag_text
 * @property-read \SupportCollection $flags
 * @property-read \Collection|\ProductImage[]|string[] $gallery
 * @property-read bool $has_flag
 * @property-read string|null $image_alt
 * @property-read string|null $image_title
 * @property-read \Illuminate\Support\Collection|\Product[] $variations
 * @property-read \Illuminate\Database\Eloquent\Collection|\WezomCms\Catalog\Models\ProductImage[] $images
 * @property-read int|null $images_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\WezomCms\Catalog\Models\ProductImage[] $mainImage
 * @property-read int|null $main_image_count
 * @property-read \WezomCms\Catalog\Models\Model|null $model
 * @property-read \Illuminate\Database\Eloquent\Collection|\WezomCms\Catalog\Models\ProductSpecification[] $productSpecifications
 * @property-read int|null $product_specifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\WezomCms\Catalog\Models\Specifications\Specification[] $specifications
 * @property-read int|null $specifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\WezomCms\Catalog\Models\Specifications\SpecValue[] $specificationsValues
 * @property-read int|null $specifications_values_count
 * @property-read \WezomCms\Catalog\Models\ProductTranslation $translation
 * @property-read \Illuminate\Database\Eloquent\Collection|\WezomCms\Catalog\Models\ProductTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Product filter($input = [], $filter = null)
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Product listsTranslations($translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Product notTranslatedIn($locale = null)
 * @method static \Illuminate\Database\Query\Builder|\WezomCms\Catalog\Models\Product onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Product orWhereTranslation($translationField, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Product orWhereTranslationLike($translationField, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Product orderByTranslation($translationField, $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Product paginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Product published()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Product publishedWithSlug($slug, $slugField = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Product query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Product simplePaginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Product sorting()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Product translated()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Product translatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Product whereAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Product whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Product whereBrandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Product whereColorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Product whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Product whereDiscountPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Product whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Product whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Product whereGroupKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Product whereLike($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Product whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Product whereNovelty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Product whereOldCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Product wherePopular($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Product wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Product whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Product whereSale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Product whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Product whereTranslation($translationField, $value, $locale = null, $method = 'whereHas', $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Product whereTranslationLike($translationField, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Product whereVideos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Product withTranslation()
 * @method static \Illuminate\Database\Query\Builder|\WezomCms\Catalog\Models\Product withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\WezomCms\Catalog\Models\Product withoutTrashed()
 * @mixin \Eloquent
 * @mixin ProductTranslation
 */
class Product extends EloquentModel implements StorageInterface, Favorable, PurchasedProductInterface
{
    use EloquentTentacle;
    use Filterable;
    use HasFactory;
    use Translatable;
    use ProductFlagsTrait;
    use ProductImageTrait;
    use FavorableTrait;
    use PurchasedProductTrait;
    use PublishedTrait;
    use SoftDeletes;
    use OrderBySort;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'published', 'group_key', 'cost', 'old_cost', 'category_id', 'brand_id', 'model_id',
        'novelty', 'popular', 'sale', 'videos', 'type', 'available', 'vendor_code'];

    /**
     * Names of the fields being translated in the "Translation" model.
     *
     * @var array
     */
    protected $translatedAttributes = ['name', 'slug', 'text', 'title', 'h1', 'keywords', 'description'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'published' => 'bool',
        'novelty' => 'bool',
        'popular' => 'bool',
        'sale' => 'bool',
        'videos' => 'array',
        'available' => 'bool',
        'cost' => 'float',
        'old_cost' => 'float',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['expires_at'];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translation'];

    /**
     * @param string|null $search
     * @param array $criterion
     * @param int $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function search(string $search = null, array $criterion = [], int $limit = 10)
    {
        $query = Product::query()->withTrashed();

        if ($search) {
            $query->whereTranslationLike('name', '%' . Helpers::escapeLike($search) . '%');
        }

        if (!empty($criterion)) {
            foreach ($criterion as $field => $value) {
                if (in_array($field, ['category_id'])) {
                    $query->where($field, $value);
                }
            }
        }

        return $query->paginate($limit);
    }

    public static function getByFlag(string $flag, $limit = 12): Collection
    {
        $ids = Product::where($flag, true)
            ->available()
            ->published()
            ->withoutTrashed()
            ->getQuery()
            ->pluck('id');

        if ($ids->isEmpty()) {
            return collect();
        }

        $limit = $limit > $ids->count() ? $ids->count() : $limit;

        return Product::whereIn('id', $ids->random($limit))
            ->fullSelection()
            ->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function model()
    {
        return $this->belongsTo(Model::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function specifications()
    {
        return $this->belongsToMany(Specification::class, 'product_specifications', 'product_id', 'spec_id');
    }

    public function productAccessories(): BelongsToMany
    {
        return $this->belongsToMany(static::class, 'product_accessories', 'owner_product_id', 'product_id');
    }

    public function productAccessoriesReversed(): BelongsToMany
    {
        return $this->belongsToMany(static::class, 'product_accessories', 'product_id', 'owner_product_id');
    }

    /**
     * @return Builder|\Illuminate\Database\Eloquent\Relations\HasOneThrough
     */
    public function color()
    {
        return $this->hasOneThrough(
            SpecValue::class,
            ProductPrimarySpecValue::class,
            'product_id',
            'id',
            'id',
            'spec_value_id'
        )->whereHas('specification', function ($query) {
            $query->whereType(Specification::COLOR);
        });
    }

    /**
     * @return HasMany
     */
    public function combinedProducts()
    {
        return $this->hasMany(Product::class, 'group_key', 'group_key')
            ->whereNotNull('group_key')
            ->where('group_key', '!=', '')
            ->select('products.*')
            ->with(['color' => published_scope()])
            ->published();
    }

    /**
     * @return mixed
     */
    public function publishedSpecifications()
    {
        return $this->specificationsValues()
            ->published()
            ->whereHas('specification', published_scope())
            ->with(['specification' => published_scope()]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function specificationsValues()
    {
        return $this->belongsToMany(SpecValue::class, 'product_specifications');
    }

    /**
     * Store a new view.
     */
    public function addView()
    {
        ViewedProducts::add($this->id);
    }

    /**
     * @param array $specValues
     * @param array $primarySpecValues
     */
    public function updateSpecValueRelation($specValues = [], $primarySpecValues = [])
    {
        $items = array_filter(array_map('array_filter', $specValues));

        if (!empty($primarySpecValues)) {
            $primaryItems = SpecValue::whereKey($primarySpecValues)
                ->get()
                ->mapToGroups(function (SpecValue $specValue) {
                    return [$specValue->specification_id => $specValue->id];
                });
            foreach ($primaryItems as $specId => $ids) {
                $items[$specId] = $ids->all();
            }
        }

        $this->productSpecifications()->delete();

        // transform to flatten array
        foreach ($items as $specId => $values) {
            foreach ($values as $value) {
                $this->productSpecifications()->create(['spec_id' => $specId, 'spec_value_id' => $value]);
            }
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productSpecifications()
    {
        return $this->hasMany(ProductSpecification::class);
    }

    /**
     * @return string
     */
    public function getFrontUrl()
    {
        return route('catalog.product', [$this->slug, $this->id]);
    }

    public function getDiscountPercentAttribute(): int
    {
        return round($this->discountCostDistinction * 100 / $this->old_cost);
    }

    public function getDiscountCostDistinctionAttribute(): int
    {
        return $this->old_cost - $this->cost;
    }

    public function getSelectedSpecificationsAttribute()
    {
        return $this->primarySpecValues()
            ->published()
            ->whereHas('specification', published_scope())
            ->get()
            ->toBase()
            ->mapWithKeys(function (SpecValue $specValue) {
                return [$specValue->specification_id => $specValue->id];
            })
            ->unique()
            ->all();
    }

    public function getSelectedSpecValuesAttribute()
    {
        return $this->primarySpecValues()
            ->published()
            ->whereHas('specification', published_scope())
            ->get()
            ->toBase()
            ->mapWithKeys(function (SpecValue $specValue) {
                return [$specValue->id => $specValue->specification_id];
            });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function primarySpecValues()
    {
        return $this->belongsToMany(SpecValue::class, 'product_primary_spec_value')
            ->orderBy('spec_values.sort')
            ->orderByDesc('spec_values.id');
    }

    /**
     * @return \Illuminate\Support\Collection|Product[]
     */
    public function getVariationsAttribute()
    {
        $result = $this->combinedProducts;

        if ($result->count() < 2) {
            return collect();
        }

        return $result->sortBy('color.sort');
    }

    /**
     * @param bool $fullSelection
     * @return mixed
     */
    public function beginSelection(bool $fullSelection = true)
    {
        $query = $this->query()
            ->select('products.*')
            ->published();

        if ($fullSelection) {
            $query->fullSelection()
                ->orderByDesc('available');
        }

        return $query;
    }

    /**
     * @return mixed
     */
    public function beginCount()
    {
        return $this->query()->published();
    }

    public function scopeFullSelection($query)
    {
        return $query->with([
            'images'
        ])
            ->withCount('publishedReviews');
    }

    public function scopeAvailable($query, $available = true)
    {
        return $query->where('available', $available);
    }
}
