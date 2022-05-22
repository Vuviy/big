<?php

namespace WezomCms\Slider\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use WezomCms\Core\ExtendPackage\Translatable;
use WezomCms\Core\Traits\Model\Filterable;
use WezomCms\Core\Traits\Model\ImageAttachable;
use WezomCms\Core\Traits\Model\OrderBySort;
use WezomCms\Core\Traits\Model\PublishedTrait;

/**
 * \WezomCms\Slider\Models\Slide
 *
 * @property int $id
 * @property int $sort
 * @property bool $open_in_new_tab
 * @property string $slider
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\WezomCms\Slider\Models\SlideTranslation[] $translations
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Slider\Models\Slide filter($input = array(), $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Slider\Models\Slide listsTranslations($translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Slider\Models\Slide newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Slider\Models\Slide newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Slider\Models\Slide notTranslatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Slider\Models\Slide orWhereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Slider\Models\Slide orWhereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Slider\Models\Slide orderByTranslation($key, $sortmethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Slider\Models\Slide paginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Slider\Models\Slide published()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Slider\Models\Slide publishedWithSlug($slug, $slugField = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Slider\Models\Slide query()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Slider\Models\Slide simplePaginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Slider\Models\Slide sorting()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Slider\Models\Slide translated()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Slider\Models\Slide translatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Slider\Models\Slide whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Slider\Models\Slide whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Slider\Models\Slide whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Slider\Models\Slide whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Slider\Models\Slide whereLike($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Slider\Models\Slide whereOpenInNewTab($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Slider\Models\Slide whereSlider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Slider\Models\Slide whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Slider\Models\Slide whereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Slider\Models\Slide whereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Slider\Models\Slide whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Slider\Models\Slide withTranslation()
 * @mixin \Eloquent
 * @mixin SlideTranslation
 */
class Slide extends Model
{
    use ImageAttachable;
    use Translatable;
    use Filterable;
    use HasFactory;
    use PublishedTrait;
    use OrderBySort;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['sort', 'open_in_new_tab', 'slider', 'price'];

    /**
     * Names of the fields being translated in the "Translation" model.
     *
     * @var array
     */
    protected $translatedAttributes = ['published', 'name', 'url', 'description_1', 'description_2'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['open_in_new_tab' => 'bool'];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translation'];

    /**
     * @return array
     */
    public function imageSettings(): array
    {
        return [
            'image' => 'cms.slider.slider.images',
            'image_mobile' => 'cms.slider.slider.image_mobile'
        ];
    }
}
