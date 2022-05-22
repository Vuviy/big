<?php

namespace WezomCms\Catalog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use WezomCms\Catalog\Models\Specifications\Specification;
use WezomCms\Core\ExtendPackage\Translatable;
use WezomCms\Core\Foundation\Helpers;
use WezomCms\Core\Traits\Model\Filterable;
use WezomCms\Core\Traits\Model\ImageAttachable;
use WezomCms\Core\Traits\Model\OrderBySort;
use WezomCms\Core\Traits\Model\PublishedTrait;
use WezomCms\Menu\Traits\MenuItemTrait;

/**
 * \WezomCms\Catalog\Models\Category
 *
 * @property int $id
 * @property bool $published
 * @property int $sort
 * @property int|null $parent_id
 * @property string|null $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $show_on_main
 * @property-read \Illuminate\Database\Eloquent\Collection|\WezomCms\Catalog\Models\CatalogSeoTemplate[] $catalogSeoTemplate
 * @property-read int|null $catalog_seo_template_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\WezomCms\Catalog\Models\Category[] $children
 * @property-read int|null $children_count
 * @property-read \WezomCms\Catalog\Models\Category|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection|\WezomCms\Catalog\Models\Product[] $products
 * @property-read int|null $products_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\WezomCms\Catalog\Models\Category[] $similarCategories
 * @property-read int|null $similar_categories_count
 * @property-read \WezomCms\Catalog\Models\CategoryTranslation $translation
 * @property-read \Illuminate\Database\Eloquent\Collection|\WezomCms\Catalog\Models\CategoryTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Category filter($input = array(), $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Category listsTranslations($translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Category notTranslatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Category orWhereTranslation($translationField, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Category orWhereTranslationLike($translationField, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Category orderByTranslation($translationField, $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Category paginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Category published()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Category publishedWithSlug($slug, $slugField = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Category simplePaginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Category sorting()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Category translated()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Category translatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Category whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Category whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Category whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Category whereLike($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Category whereShowOnMain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Category whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Category wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Category whereTranslation($translationField, $value, $locale = null, $method = 'whereHas', $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Category whereTranslationLike($translationField, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\Category withTranslation()
 * @mixin \Eloquent
 * @mixin CategoryTranslation
 */
class Category extends EloquentModel
{
    use Translatable;
    use ImageAttachable;
    use Filterable;
    use HasFactory;
    use PublishedTrait;
    use MenuItemTrait;
    use OrderBySort;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'published', 'parent_id', 'sort', 'show_on_main', 'show_on_menu'];

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
    protected $casts = ['published' => 'bool', 'show_on_main' => 'bool', 'show_on_menu' => 'bool'];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translation'];

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted()
    {
        static::deleting(function (Category $category) {
            $category->children()->update(['parent_id' => $category->parent_id]);
        });
    }

    /**
     * @param  string  $prefix
     * @return array
     */
    public static function getForSiteMap($prefix = 'catalog')
    {
        return Category::published()
            ->sorting()
            ->get()
            ->map(function (Category $category) use ($prefix) {
                return [
                    'id' => 'catalog-' . $category->id,
                    'parent_id' => $category->parent_id ? $prefix . '-' . $category->parent_id : $prefix,
                    'sort' => $category->sort,
                    'name' => $category->name,
                    'url' => $category->getFrontUrl(),
                ];
            })
            ->toArray();
    }

    /**
     * @return array
     */
    public function imageSettings(): array
    {
        return [
            'image' => 'cms.catalog.categories.images.image',
        ];
    }

    /**
     * @return string
     */
    public function getFrontUrl()
    {
        return route('catalog.category', [$this->slug, $this->id]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function specifications()
    {
        return $this->belongsToMany(Specification::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function catalogSeoTemplate()
    {
        return $this->belongsToMany(CatalogSeoTemplate::class, 'category_catalog_seo_template');
    }

    public function similarCategories()
    {
        return $this->belongsToMany(Category::class, 'category_by_similar', 'category_id', 'similar_category_id');
    }

    /**
     * @return array
     */
    public function getAllRootsCategoriesId()
    {
        $result = [];

        $category = $this;

        while ($category->parent_id !== null) {
            $category = Category::published()->find($category->parent_id);
            if (!$category) {
                break;
            }

            $result[] = $category->id;
        }

        return $result;
    }

    /**
     * @param  callable|null  $callback
     * @return array
     */
    public static function getForSelect(callable $callback = null)
    {
        $query = static::select()
            ->sorting();

        if (null !== $callback) {
            $callback($query);
        }

        $tree = Helpers::groupByParentId($query->get());

        return static::addTreeSpaces($tree);
    }

    /**
     * @param  array  $tree
     * @param  null  $id
     * @param  array  $result
     * @param  string  $space
     * @return array
     */
    private static function addTreeSpaces(array $tree, $id = null, array &$result = [], $space = '')
    {
        foreach ($tree[$id] ?? [] as $group) {
            if (isset($tree[$group->id])) {
                $result[$group->id] = ['disabled' => true, 'name' => $space . $group->name];
                static::addTreeSpaces($tree, $group->id, $result, $space . '&nbsp;&nbsp;&nbsp;&nbsp;');
            } else {
                $result[$group->id] = ['name' => $space . $group->name];
            }
        }

        return $result;
    }

    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }
}
