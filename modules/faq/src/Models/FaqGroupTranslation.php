<?php

namespace WezomCms\Faq\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * \WezomCms\Faq\Models\FaqGroupTranslation
 *
 * @property int $id
 * @property int $faq_group_id
 * @property string $name
 * @property string $locale
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqGroupTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqGroupTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqGroupTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqGroupTranslation whereFaqGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqGroupTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqGroupTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqGroupTranslation whereName($value)
 * @mixin \Eloquent
 */
class FaqGroupTranslation extends Model
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
    protected $fillable = ['name'];
}
