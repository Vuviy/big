<?php

namespace WezomCms\Seo\Models;

use Illuminate\Database\Eloquent\Model;
use WezomCms\Core\Traits\Model\Filterable;
use WezomCms\Core\Traits\Model\PublishedTrait;

/**
 * \WezomCms\Seo\Models\SeoLink
 *
 * @property int $id
 * @property string $name
 * @property bool $published
 * @property string $link
 * @property string|null $title
 * @property string|null $h1
 * @property string|null $keywords
 * @property string|null $description
 * @property string|null $seo_text
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Seo\Models\SeoLink filter($input = array(), $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Seo\Models\SeoLink newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Seo\Models\SeoLink newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Seo\Models\SeoLink paginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Seo\Models\SeoLink query()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Seo\Models\SeoLink simplePaginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Seo\Models\SeoLink whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Seo\Models\SeoLink whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Seo\Models\SeoLink whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Seo\Models\SeoLink whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Seo\Models\SeoLink whereH1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Seo\Models\SeoLink whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Seo\Models\SeoLink whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Seo\Models\SeoLink whereLike($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Seo\Models\SeoLink whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Seo\Models\SeoLink whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Seo\Models\SeoLink whereSeoText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Seo\Models\SeoLink wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Seo\Models\SeoLink whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Seo\Models\SeoLink whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SeoLink extends Model
{
    use Filterable;
    use PublishedTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'published', 'link', 'title', 'h1', 'keywords', 'description', 'seo_text'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['published' => 'bool'];

    /**
     * @param  bool  $published
     * @return null|static
     */
    public static function findByCurrentLink(bool $published = true)
    {
        $uri = app('request')->getRequestUri();

        return static::where('link', $uri)
            ->where('published', $published)
            ->first();
    }

    /**
     * Set the link attribute.
     *
     * @param  string  $value
     */
    public function setLinkAttribute($value)
    {
        $this->attributes['link'] = '/' . ltrim($value, '/');
    }
}
