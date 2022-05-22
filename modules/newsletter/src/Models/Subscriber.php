<?php

namespace WezomCms\Newsletter\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use WezomCms\Core\Traits\Model\Filterable;
use WezomCms\Newsletter\Storage\SubscriptionCookieStorage;
use WezomCms\Users\Models\User;

/**
 * \WezomCms\Newsletter\Models\Subscriber
 *
 * @property int $id
 * @property string $email
 * @property int|null $user_id
 * @property string|null $ip
 * @property bool $active
 * @property string $locale
 * @property string $token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Newsletter\Models\Subscriber active()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Newsletter\Models\Subscriber filter($input = array(), $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Newsletter\Models\Subscriber newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Newsletter\Models\Subscriber newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Newsletter\Models\Subscriber paginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Newsletter\Models\Subscriber query()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Newsletter\Models\Subscriber simplePaginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Newsletter\Models\Subscriber whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Newsletter\Models\Subscriber whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Newsletter\Models\Subscriber whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Newsletter\Models\Subscriber whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Newsletter\Models\Subscriber whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Newsletter\Models\Subscriber whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Newsletter\Models\Subscriber whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Newsletter\Models\Subscriber whereLike($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Newsletter\Models\Subscriber whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Newsletter\Models\Subscriber whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Newsletter\Models\Subscriber whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Newsletter\Models\Subscriber whereUserId($value)
 * @mixin \Eloquent
 */
class Subscriber extends Model
{
    use Notifiable;
    use Filterable;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email', 'user_id', 'token', 'ip', 'active', 'locale'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['active' => 'bool'];

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->token = SubscriptionCookieStorage::generateHash();
        });
    }

    /**
     * @param  Builder  $query
     */
    public function scopeActive(Builder $query)
    {
        $query->where('active', true);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return string
     */
    public function getUnsubscribeUrl()
    {
        return route('newsletter.unsubscribe', $this->token);
    }
}
