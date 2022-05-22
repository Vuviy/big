<?php

namespace WezomCms\Pages\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use WezomCms\Core\ExtendPackage\Translatable;
use WezomCms\Core\Traits\Model\Filterable;
use WezomCms\Core\Traits\Model\GetForSelectTrait;
use WezomCms\Core\Traits\Model\PublishedTrait;

/**
 * \WezomCms\Pages\Models\Page
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \WezomCms\Pages\Models\PageTranslation $translation
 * @property-read \Illuminate\Database\Eloquent\Collection|\WezomCms\Pages\Models\PageTranslation[] $translations
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Pages\Models\Page filter($input = array(), $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Pages\Models\Page listsTranslations($translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Pages\Models\Page newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Pages\Models\Page newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Pages\Models\Page notTranslatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Pages\Models\Page orWhereTranslation($translationField, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Pages\Models\Page orWhereTranslationLike($translationField, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Pages\Models\Page orderByTranslation($translationField, $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Pages\Models\Page paginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Pages\Models\Page published()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Pages\Models\Page publishedWithSlug($slug, $slugField = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Pages\Models\Page query()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Pages\Models\Page simplePaginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Pages\Models\Page translated()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Pages\Models\Page translatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Pages\Models\Page whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Pages\Models\Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Pages\Models\Page whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Pages\Models\Page whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Pages\Models\Page whereLike($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Pages\Models\Page whereTranslation($translationField, $value, $locale = null, $method = 'whereHas', $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Pages\Models\Page whereTranslationLike($translationField, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Pages\Models\Page whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Pages\Models\Page withTranslation()
 * @mixin \Eloquent
 * @mixin PageTranslation
 */
class Page extends Model
{
    use Translatable;
    use Filterable;
    use GetForSelectTrait;
    use HasFactory;
    use PublishedTrait;

    /**
     * Names of the fields being translated in the "Translation" model.
     *
     * @var array
     */
    protected $translatedAttributes = ['published', 'slug', 'name', 'text', 'title', 'h1', 'keywords', 'description'];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translation'];

    /**
     * @return string
     */
    public function getFrontUrl()
    {
        return route('page.inner', $this->slug);
    }
}
