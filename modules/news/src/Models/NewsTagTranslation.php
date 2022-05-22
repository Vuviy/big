<?php

namespace WezomCms\News\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * \WezomCms\News\Models\NewsTagTranslation
 *
 * @property int $id
 * @property int $news_tag_id
 * @property string|null $name
 * @property string|null $title
 * @property string|null $h1
 * @property string|null $keywords
 * @property string|null $description
 * @property string $locale
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTagTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTagTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTagTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTagTranslation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTagTranslation whereH1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTagTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTagTranslation whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTagTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTagTranslation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTagTranslation whereNewsTagId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\News\Models\NewsTagTranslation whereTitle($value)
 * @mixin \Eloquent
 */
class NewsTagTranslation extends Model
{
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
    protected $fillable = ['name', 'title', 'h1', 'keywords', 'description'];
}
