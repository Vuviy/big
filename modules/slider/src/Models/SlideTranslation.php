<?php

namespace WezomCms\Slider\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * \WezomCms\Slider\Models\SlideTranslation
 *
 * @property int $id
 * @property int $slide_id
 * @property bool $published
 * @property string|null $name
 * @property string|null $url
 * @property string|null $image
 * @property string $locale
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Slider\Models\SlideTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Slider\Models\SlideTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Slider\Models\SlideTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Slider\Models\SlideTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Slider\Models\SlideTranslation whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Slider\Models\SlideTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Slider\Models\SlideTranslation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Slider\Models\SlideTranslation whereSlideId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Slider\Models\SlideTranslation wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Slider\Models\SlideTranslation whereUrl($value)
 * @mixin \Eloquent
 */
class SlideTranslation extends Model
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
    protected $fillable = ['published', 'name', 'url', 'slider', 'description_1', 'description_2'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['published' => 'bool'];
}
