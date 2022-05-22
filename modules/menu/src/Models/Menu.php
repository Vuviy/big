<?php

namespace WezomCms\Menu\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LaravelLocalization;
use WezomCms\Core\ExtendPackage\Translatable;
use WezomCms\Core\Traits\Model\Filterable;
use WezomCms\Core\Traits\Model\OrderBySort;
use WezomCms\Core\Traits\Model\PublishedTrait;

/**
 * WezomCms\Menu\Models\Menu
 *
 * @property int $id
 * @property int $sort
 * @property string $group
 * @property int|null $parent_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\WezomCms\Menu\Models\Menu[] $children
 * @property-read int|null $children_count
 * @property-read \WezomCms\Menu\Models\MenuTranslation $translation
 * @property-read \Illuminate\Database\Eloquent\Collection|\WezomCms\Menu\Models\MenuTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Menu\Models\Menu filter($input = [], $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Menu\Models\Menu listsTranslations($translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Menu\Models\Menu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Menu\Models\Menu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Menu\Models\Menu notTranslatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Menu\Models\Menu orWhereTranslation($translationField, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Menu\Models\Menu orWhereTranslationLike($translationField, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Menu\Models\Menu orderByTranslation($translationField, $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Menu\Models\Menu paginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Menu\Models\Menu published()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Menu\Models\Menu publishedWithSlug($slug, $slugField = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Menu\Models\Menu query()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Menu\Models\Menu simplePaginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Menu\Models\Menu sorting()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Menu\Models\Menu translated()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Menu\Models\Menu translatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Menu\Models\Menu whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Menu\Models\Menu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Menu\Models\Menu whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Menu\Models\Menu whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Menu\Models\Menu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Menu\Models\Menu whereLike($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Menu\Models\Menu whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Menu\Models\Menu whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Menu\Models\Menu whereTranslation($translationField, $value, $locale = null, $method = 'whereHas', $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Menu\Models\Menu whereTranslationLike($translationField, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Menu\Models\Menu whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Menu\Models\Menu withTranslation()
 * @mixin \Eloquent
 * @mixin MenuTranslation
 */
class Menu extends Model
{
    use Filterable;
    use HasFactory;
    use Translatable;
    use PublishedTrait;
    use OrderBySort;

    public const MODE_SPAN = 'span';
    public const MODE_LINK = 'link';

    public const HEADER_GROUP = 'header';
    public const HEADER_CATALOG_GROUP = 'header-catalog';
    public const FOOTER_GROUP = 'footer';
    public const MOBILE_GROUP = 'mobile';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'menu';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['parent_id', 'group', 'sort'];

    /**
     * Names of the fields being translated in the "Translation" model.
     *
     * @var array
     */
    protected $translatedAttributes = ['published', 'name', 'url'];

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
        // Update group in all children
        static::updated(function (Menu $obj) {
            if ($obj->getOriginal('group') !== $obj->group && $children = $obj->children) {
                foreach ($children as $child) {
                    $child->group = $obj->group;
                    $child->save();
                }
            }
        });

        // Set paren_id to null in all children
        static::deleted(function (Menu $obj) {
            $obj->children->each(function (Menu $item) {
                $item->update(['parent_id' => null]);
            });
        });
    }

    /**
     * @return string
     */
    public function getFrontUrl()
    {
        return url($this->url);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }

    /**
     * @return array|\Illuminate\Contracts\Translation\Translator|null|string
     */
    public function getGroupName()
    {
        $name = config("cms.menu.menu.groups.{$this->group}.name");

        if ($name) {
            return __($name);
        }

        return null;
    }

    /**
     * @return string|null
     */
    public function activeMode(): ?string
    {
        $currentUrl = app('request')->getPathInfo();

        $url = parse_url($this->url, PHP_URL_PATH);

        if ($url === $currentUrl) {
            return static::MODE_SPAN;
        }

        $defaultLocale = LaravelLocalization::getDefaultLocale();

        $trimmedUrl = preg_replace("#^(\/{$defaultLocale}|{$defaultLocale})#", '', $url);
        $trimmedUrl = '/' . ltrim($trimmedUrl, '/');

        if ($trimmedUrl === $currentUrl) {
            return static::MODE_SPAN;
        }

        // Remove current locale
        $locale = app()->getLocale();
        $trimmedUrl = preg_replace("#^\/{$locale}#", '', $trimmedUrl);
        $currentUrl = preg_replace("#^(\/{$locale}|{$locale})#", '', $currentUrl);

        if ($currentUrl !== '/' && $url !== '/' && $trimmedUrl && strpos($currentUrl, $trimmedUrl . '/') === 0) {
            return static::MODE_LINK;
        }

        return null;
    }
}
