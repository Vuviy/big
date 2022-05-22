<?php

namespace WezomCms\News\Models;

use Illuminate\Database\Eloquent\Model;
use WezomCms\Core\Traits\Model\MultiLanguageSluggableTrait;

/**
 * \WezomCms\News\Models\NewsTranslation
 *
 * @property int $id
 * @property int $news_id
 * @property bool $published
 * @property string|null $slug
 * @property string|null $name
 * @property string|null $text
 * @property string|null $title
 * @property string|null $h1
 * @property string|null $keywords
 * @property string|null $description
 * @property string $locale
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTranslation findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTranslation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTranslation whereH1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTranslation whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTranslation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTranslation whereNewsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTranslation whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTranslation wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTranslation whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTranslation whereTitle($value)
 * @mixin \Eloquent
 */
class NewsTranslation extends Model
{
    use MultiLanguageSluggableTrait;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['published', 'slug', 'name', 'text', 'title', 'h1', 'keywords', 'description'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['published' => 'bool'];
}
