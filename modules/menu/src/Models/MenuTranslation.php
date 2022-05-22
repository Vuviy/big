<?php

namespace WezomCms\Menu\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * WezomCms\Menu\Models\MenuTranslation
 *
 * @property int $id
 * @property int $menu_id
 * @property string $locale
 * @property bool $published
 * @property string|null $name
 * @property string|null $url
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Menu\Models\MenuTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Menu\Models\MenuTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Menu\Models\MenuTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Menu\Models\MenuTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Menu\Models\MenuTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Menu\Models\MenuTranslation whereMenuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Menu\Models\MenuTranslation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Menu\Models\MenuTranslation wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Menu\Models\MenuTranslation whereUrl($value)
 * @mixin \Eloquent
 */
class MenuTranslation extends Model
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
    protected $fillable = ['published', 'name', 'url'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['published' => 'bool'];
}
