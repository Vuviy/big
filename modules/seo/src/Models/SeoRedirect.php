<?php

namespace WezomCms\Seo\Models;

use Illuminate\Database\Eloquent\Model;
use WezomCms\Core\Traits\Model\Filterable;

/**
 * \WezomCms\Seo\Models\SeoRedirect
 *
 * @property int $id
 * @property string|null $name
 * @property bool $published
 * @property string $link_from
 * @property string $link_to
 * @property string $http_status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Seo\Models\SeoRedirect filter($input = array(), $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Seo\Models\SeoRedirect newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Seo\Models\SeoRedirect newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Seo\Models\SeoRedirect paginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Seo\Models\SeoRedirect query()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Seo\Models\SeoRedirect simplePaginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Seo\Models\SeoRedirect whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Seo\Models\SeoRedirect whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Seo\Models\SeoRedirect whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Seo\Models\SeoRedirect whereHttpStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Seo\Models\SeoRedirect whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Seo\Models\SeoRedirect whereLike($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Seo\Models\SeoRedirect whereLinkFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Seo\Models\SeoRedirect whereLinkTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Seo\Models\SeoRedirect whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Seo\Models\SeoRedirect wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Seo\Models\SeoRedirect whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SeoRedirect extends Model
{
    use Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'published', 'link_from', 'link_to', 'http_status'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['published' => 'bool'];
}
