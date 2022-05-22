<?php

namespace WezomCms\Callbacks\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use WezomCms\Core\Traits\Model\Filterable;

/**
 * WezomCms\Callbacks\Models\Callback
 *
 * @property int $id
 * @property string|null $name
 * @property string $phone
 * @property bool $read
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Callbacks\Models\Callback filter($input = [], $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Callbacks\Models\Callback newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Callbacks\Models\Callback newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Callbacks\Models\Callback paginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Callbacks\Models\Callback query()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Callbacks\Models\Callback simplePaginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Callbacks\Models\Callback whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Callbacks\Models\Callback whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Callbacks\Models\Callback whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Callbacks\Models\Callback whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Callbacks\Models\Callback whereLike($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Callbacks\Models\Callback whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Callbacks\Models\Callback wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Callbacks\Models\Callback whereRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Callbacks\Models\Callback whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Callback extends Model
{
    use Filterable;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'phone', 'read'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['read' => 'bool'];
}
