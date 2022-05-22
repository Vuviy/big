<?php

namespace WezomCms\MediaBlocks\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * \WezomCms\MediaBlocks\Models\MediaBlockTranslation
 *
 * @property int $id
 * @property int $creeping_line_id
 * @property bool $published
 * @property string|null $name
 * @property string|null $url
 * @property string $locale
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\MediaBlocks\Models\MediaBlockTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\MediaBlocks\Models\MediaBlockTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\MediaBlocks\Models\MediaBlockTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\MediaBlocks\Models\MediaBlockTranslation whereCreepingLineId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\MediaBlocks\Models\MediaBlockTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\MediaBlocks\Models\MediaBlockTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\MediaBlocks\Models\MediaBlockTranslation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\MediaBlocks\Models\MediaBlockTranslation wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\MediaBlocks\Models\MediaBlockTranslation whereUrl($value)
 * @mixin \Eloquent
 */
class MediaBlockTranslation extends Model
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
    protected $fillable = ['name', 'description', 'url'];
}
