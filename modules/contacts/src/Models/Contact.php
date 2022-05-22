<?php

namespace WezomCms\Contacts\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use WezomCms\Core\Traits\Model\Filterable;

/**
 * WezomCms\Contacts\Models\Contact
 *
 * @property int $id
 * @property bool $read
 * @property string|null $name
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $city
 * @property string|null $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Contacts\Models\Contact filter($input = [], $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Contacts\Models\Contact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Contacts\Models\Contact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Contacts\Models\Contact paginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Contacts\Models\Contact query()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Contacts\Models\Contact simplePaginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Contacts\Models\Contact unread()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Contacts\Models\Contact whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Contacts\Models\Contact whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Contacts\Models\Contact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Contacts\Models\Contact whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Contacts\Models\Contact whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Contacts\Models\Contact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Contacts\Models\Contact whereLike($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Contacts\Models\Contact whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Contacts\Models\Contact whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Contacts\Models\Contact wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Contacts\Models\Contact whereRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Contacts\Models\Contact whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Contact extends Model
{
    use Filterable;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['read', 'name', 'phone', 'email', 'city', 'message'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['read' => 'bool'];

    /**
     * @param  Builder  $query
     */
    public function scopeUnread(Builder $query)
    {
        $query->where('read', false);
    }
}
