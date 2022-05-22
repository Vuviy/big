<?php

namespace WezomCms\Credit\Models;

use Illuminate\Database\Eloquent\Model;
use WezomCms\Core\Traits\Model\OrderBySort;
use WezomCms\Core\Traits\Model\PublishedTrait;

/**
 * \WezomCms\Credit\Models\HomeCreditCoefficient
 *
 * @property int $id
 * @property bool $published
 * @property int $month
 * @property string $type
 * @property string $coefficient
 * @property int $availability
 * @property int $max_sum
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|HomeCreditCoefficient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HomeCreditCoefficient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HomeCreditCoefficient published()
 * @method static \Illuminate\Database\Eloquent\Builder|HomeCreditCoefficient publishedWithSlug($slug, $slugField = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|HomeCreditCoefficient query()
 * @method static \Illuminate\Database\Eloquent\Builder|HomeCreditCoefficient whereAvailability($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomeCreditCoefficient whereCoefficient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomeCreditCoefficient whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomeCreditCoefficient whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomeCreditCoefficient whereMaxSum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomeCreditCoefficient whereMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomeCreditCoefficient wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomeCreditCoefficient whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HomeCreditCoefficient whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class HomeCreditCoefficient extends Model
{
    use OrderBySort;
    use PublishedTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['published', 'month', 'type', 'coefficient', 'availability', 'max_sum'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = ['published' => 'bool'];

    /**
     * Specifying the field by which to sort records.
     *
     * @var string
     */
    protected $sortField = 'month';
}
