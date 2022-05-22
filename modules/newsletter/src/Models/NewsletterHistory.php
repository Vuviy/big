<?php

namespace WezomCms\Newsletter\Models;

use Illuminate\Database\Eloquent\Model;
use WezomCms\Core\Traits\Model\Filterable;

/**
 * \WezomCms\Newsletter\Models\NewsletterHistory
 *
 * @property int $id
 * @property string $subject
 * @property string $text
 * @property string $locale
 * @property int $count_emails
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Newsletter\Models\NewsletterHistory filter($input = array(), $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Newsletter\Models\NewsletterHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Newsletter\Models\NewsletterHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Newsletter\Models\NewsletterHistory paginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Newsletter\Models\NewsletterHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Newsletter\Models\NewsletterHistory simplePaginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Newsletter\Models\NewsletterHistory whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Newsletter\Models\NewsletterHistory whereCountEmails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Newsletter\Models\NewsletterHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Newsletter\Models\NewsletterHistory whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Newsletter\Models\NewsletterHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Newsletter\Models\NewsletterHistory whereLike($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Newsletter\Models\NewsletterHistory whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Newsletter\Models\NewsletterHistory whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Newsletter\Models\NewsletterHistory whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Newsletter\Models\NewsletterHistory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class NewsletterHistory extends Model
{
    use Filterable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'newsletter_history';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['subject', 'text', 'locale', 'count_emails'];

    /**
     * @var string
     */
    public $abilityPrefix = 'newsletter';
}
