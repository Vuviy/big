<?php

namespace WezomCms\News\Models;

use CyrildeWit\EloquentViewable\Contracts\Viewable as ViewableContract;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use WezomCms\Core\ExtendPackage\Translatable;
use WezomCms\Core\Traits\Model\Filterable;
use WezomCms\Core\Traits\Model\ImageAttachable;
use WezomCms\Core\Traits\Model\PrevNextTrait;
use WezomCms\Core\Traits\Model\PublishedTrait;

/**
 * \WezomCms\News\Models\News
 *
 * @property int $id
 * @property string|null $image
 * @property \Illuminate\Support\Carbon $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $file
 * @property string|null $file_original_name
 * @property string|null $second_file
 * @property string|null $second_fs
 * @property-read \Illuminate\Database\Eloquent\Collection|\WezomCms\News\Models\NewsTag[] $tags
 * @property-read \Illuminate\Database\Eloquent\Collection|\WezomCms\News\Models\NewsTranslation[] $translations
 * @property-read \Illuminate\Database\Eloquent\Collection|\CyrildeWit\EloquentViewable\View[] $views
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\News filter($input = array(), $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\News listsTranslations($translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\News newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\News newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\News notTranslatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\News orWhereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\News orWhereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\News orderByTranslation($key, $sortmethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\News orderByUniqueViews($direction = 'desc', $period = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\News orderByViews($direction = 'desc', $period = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\News paginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\News published()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\News publishedWithSlug($slug, $slugField = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\News query()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\News simplePaginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\News translated()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\News translatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\News whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\News whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\News whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\News whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\News whereFileOriginalNamea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\News whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\News whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\News whereLike($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\News wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\News whereSecondFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\News whereSecondFs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\News whereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\News whereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\News whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\News withTranslation()
 * @mixin \Eloquent
 * @mixin NewsTranslation
 */
class News extends Model implements ViewableContract
{
    use Translatable;
    use ImageAttachable;
    use Filterable;
    use HasFactory;
    use PrevNextTrait;
    use InteractsWithViews;
    use PublishedTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['published_at'];

    /**
     * Names of the fields being translated in the "Translation" model.
     *
     * @var array
     */
    protected $translatedAttributes = ['published', 'slug', 'name', 'text', 'title', 'h1', 'keywords', 'description'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['published_at'];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translation'];

    /**
     * @return array
     */
    public function imageSettings(): array
    {
        return ['image' => 'cms.news.news.images'];
    }

    /**
     * @param $query
     */
    public function filterPublished($query)
    {
        $query->where('published_at', '<=', now());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(NewsTag::class, 'news_news_tags_relation');
    }

    /**
     * @param  Builder  $query
     */
    protected function filterPrevNextSelection(Builder $query)
    {
        $query->published();
    }

    /**
     * @return array
     */
    protected function getSortField()
    {
        return ['published_at', 'id'];
    }

    /**
     * @return string
     */
    protected function getSortType()
    {
        return 'DESC';
    }

    /**
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getFrontUrl()
    {
        return route('news.inner', $this->slug);
    }

    /**
     * @return bool
     */
    public function canGoToFront(): bool
    {
        return $this->published_at <= now();
    }
}
