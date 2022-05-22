<?php

namespace WezomCms\Catalog\Models\Specifications;

use Cviebrock\EloquentSluggable\Services\SlugService;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use WezomCms\Catalog\ModelFilters\SpecificationFilter;
use WezomCms\Catalog\Models\Category;
use WezomCms\Core\ExtendPackage\Translatable;
use WezomCms\Core\Traits\Model\Filterable;
use WezomCms\Core\Traits\Model\GetForSelectTrait;
use WezomCms\Core\Traits\Model\ImageAttachable;
use WezomCms\Core\Traits\Model\OrderBySort;
use WezomCms\Core\Traits\Model\PublishedTrait;

/**
 * \WezomCms\Catalog\Models\Specifications\Specification
 *
 * @property int $id
 * @property bool $published
 * @property string $slug
 * @property int $sort
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $image
 * @property int $collapse
 * @property string|null $type
 * @property int $important
 * @property-read \Illuminate\Database\Eloquent\Collection|\WezomCms\Catalog\Models\Specifications\SpecValue[] $publishedSpecValues
 * @property-read int|null $published_spec_values_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\WezomCms\Catalog\Models\Specifications\SpecValue[] $specValues
 * @property-read int|null $spec_values_count
 * @property-read \WezomCms\Catalog\Models\Specifications\SpecificationTranslation $translation
 * @property-read \Illuminate\Database\Eloquent\Collection|\WezomCms\Catalog\Models\Specifications\SpecificationTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Specifications\Specification filter($input = array(), $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Specifications\Specification findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Specifications\Specification listsTranslations($translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Specifications\Specification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Specifications\Specification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Specifications\Specification notTranslatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Specifications\Specification orWhereTranslation($translationField, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Specifications\Specification orWhereTranslationLike($translationField, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Specifications\Specification orderByTranslation($translationField, $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Specifications\Specification paginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Specifications\Specification published()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Specifications\Specification query()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Specifications\Specification simplePaginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Specifications\Specification sorting()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Specifications\Specification translated()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Specifications\Specification translatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Specifications\Specification type($type)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Specifications\Specification whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Specifications\Specification whereCollapse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Specifications\Specification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Specifications\Specification whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Specifications\Specification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Specifications\Specification whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Specifications\Specification whereImportant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Specifications\Specification whereLike($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Specifications\Specification whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Specifications\Specification whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Specifications\Specification wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Specifications\Specification whereTranslation($translationField, $value, $locale = null, $method = 'whereHas', $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Specifications\Specification whereTranslationLike($translationField, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Specifications\Specification whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Specifications\Specification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Specifications\Specification withTranslation()
 * @mixin \Eloquent
 * @mixin SpecificationTranslation
 */
class Specification extends Model
{
    use Translatable;
    use Filterable;
    use HasFactory;
    use ImageAttachable;
    use Sluggable;
    use PublishedTrait;
    use OrderBySort;
    use GetForSelectTrait;

    public const COLOR = 'color';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['published', 'slug', 'multiple'];

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
    protected $casts = ['published' => 'bool', 'multiple' => 'bool'];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translation'];

    /**
     * @return string
     */
    protected function modelFilter(): string
    {
        return SpecificationFilter::class;
    }

    /**
     * @return array
     */
    public function imageSettings(): array
    {
        return ['image' => 'cms.catalog.specifications.images'];
    }

    /**
     * @param  Builder  $query
     * @param $type
     * @return Builder
     */
    public function scopeType(Builder $query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function specValues()
    {
        return $this->hasMany(SpecValue::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function publishedSpecValues()
    {
        return $this->hasMany(SpecValue::class)->published();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * @return mixed
     */
    public function getValuesForSelect()
    {
        $result = $this->specValues->pluck('name', 'id');

        if (!$this->multiple) {
            $result->prepend(__('cms-core::admin.layout.Not set'), '');
        }

        return $result->toArray();
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

    /**
     * @return bool
     */
    public function isColor(): bool
    {
        return $this->type === static::COLOR;
    }
}
