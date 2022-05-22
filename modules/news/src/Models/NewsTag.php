<?php

namespace WezomCms\News\Models;

use Cviebrock\EloquentSluggable\Services\SlugService;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use WezomCms\Core\ExtendPackage\Translatable;
use WezomCms\Core\Traits\Model\Filterable;
use WezomCms\Core\Traits\Model\GetForSelectTrait;
use WezomCms\Core\Traits\Model\PublishedTrait;

/**
 * WezomCms\News\Models\NewsTag
 *
 * @property int $id
 * @property bool $published
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\WezomCms\News\Models\News[] $news
 * @property-read \WezomCms\News\Models\NewsTagTranslation $translation
 * @property-read \Illuminate\Database\Eloquent\Collection|\WezomCms\News\Models\NewsTagTranslation[] $translations
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTag filter($input = array(), $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTag findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTag listsTranslations($translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTag notTranslatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTag orWhereTranslation($translationField, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTag orWhereTranslationLike($translationField, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTag orderByTranslation($translationField, $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTag paginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTag published()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTag publishedWithSlug($slug, $slugField = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTag query()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTag simplePaginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTag translated()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTag translatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTag whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTag whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTag whereLike($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTag whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTag wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTag whereTranslation($translationField, $value, $locale = null, $method = 'whereHas', $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTag whereTranslationLike($translationField, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTag whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTag withTranslation()
 * @mixin \Eloquent
 * @mixin NewsTagTranslation
 */
class NewsTag extends Model
{
    use Translatable;
    use Filterable;
    use GetForSelectTrait;
    use HasFactory;
    use Sluggable;
    use PublishedTrait;

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
    protected $translatedAttributes = ['name', 'title', 'h1', 'keywords', 'description'];

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
    public function news()
    {
        return $this->belongsToMany(News::class, 'news_news_tags_relation');
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
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getFrontUrl()
    {
        return route('news.tag', $this->slug);
    }
}
