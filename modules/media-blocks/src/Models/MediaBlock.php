<?php

namespace WezomCms\MediaBlocks\Models;

use Illuminate\Database\Eloquent\Model;
use WezomCms\Core\ExtendPackage\Translatable;
use WezomCms\Core\Traits\Model\FileAttachable;
use WezomCms\Core\Traits\Model\Filterable;
use WezomCms\Core\Traits\Model\ImageAttachable;
use WezomCms\Core\Traits\Model\PublishedTrait;

/**
 * \WezomCms\MediaBlocks\Models\MediaBlock
 *
 * @property int $id
 * @property int $sort
 * @property bool $open_in_new_tab
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \WezomCms\MediaBlocks\Models\MediaBlockTranslation|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection|\WezomCms\MediaBlocks\Models\MediaBlockTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\MediaBlocks\Models\MediaBlock filter($input = [], $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\MediaBlocks\Models\MediaBlock listsTranslations($translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\MediaBlocks\Models\MediaBlock newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\MediaBlocks\Models\MediaBlock newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\MediaBlocks\Models\MediaBlock notTranslatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\MediaBlocks\Models\MediaBlock orWhereTranslation($translationField, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\MediaBlocks\Models\MediaBlock orWhereTranslationLike($translationField, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\MediaBlocks\Models\MediaBlock orderByTranslation($translationField, $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\MediaBlocks\Models\MediaBlock paginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\MediaBlocks\Models\MediaBlock published()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\MediaBlocks\Models\MediaBlock publishedWithSlug($slug, $slugField = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\MediaBlocks\Models\MediaBlock query()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\MediaBlocks\Models\MediaBlock simplePaginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\MediaBlocks\Models\MediaBlock translated()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\MediaBlocks\Models\MediaBlock translatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\MediaBlocks\Models\MediaBlock whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\MediaBlocks\Models\MediaBlock whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\MediaBlocks\Models\MediaBlock whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\MediaBlocks\Models\MediaBlock whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\MediaBlocks\Models\MediaBlock whereLike($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\MediaBlocks\Models\MediaBlock whereOpenInNewTab($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\MediaBlocks\Models\MediaBlock whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\MediaBlocks\Models\MediaBlock whereTranslation($translationField, $value, $locale = null, $method = 'whereHas', $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\MediaBlocks\Models\MediaBlock whereTranslationLike($translationField, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\MediaBlocks\Models\MediaBlock whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\MediaBlocks\Models\MediaBlock withTranslation()
 * @mixin \Eloquent
 */
class MediaBlock extends Model
{
    use ImageAttachable;
    use FileAttachable;
    use Translatable;
    use Filterable;
    use PublishedTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['sort', 'open_in_new_tab', 'type', 'published'];

    /**
     * Names of the fields being translated in the "Translation" model.
     *
     * @var array
     */
    protected $translatedAttributes = ['name', 'description', 'url'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['open_in_new_tab' => 'bool', 'published' => 'bool'];

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
        return ['image' => 'cms.media-blocks.media-blocks.images'];
    }

    public function fileSettings(): array
    {
        return ['video' => 'cms.media-blocks.media-blocks.video'];
    }
}
