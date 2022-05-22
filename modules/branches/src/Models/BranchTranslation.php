<?php

namespace WezomCms\Branches\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * \WezomCms\Branches\Models\BranchTranslation
 *
 * @property int $id
 * @property int $branch_id
 * @property string $locale
 * @property string|null $name
 * @property string|null $address
 * @method static Builder|BranchTranslation newModelQuery()
 * @method static Builder|BranchTranslation newQuery()
 * @method static Builder|BranchTranslation query()
 * @method static Builder|BranchTranslation whereAddress($value)
 * @method static Builder|BranchTranslation whereBranchId($value)
 * @method static Builder|BranchTranslation whereId($value)
 * @method static Builder|BranchTranslation whereLocale($value)
 * @method static Builder|BranchTranslation whereName($value)
 * @mixin \Eloquent
 */
class BranchTranslation extends Model
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
    protected $fillable = ['name', 'address', 'schedule'];
}
