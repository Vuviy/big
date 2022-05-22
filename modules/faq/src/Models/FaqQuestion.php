<?php

namespace WezomCms\Faq\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use WezomCms\Core\ExtendPackage\Translatable;
use WezomCms\Core\Traits\Model\Filterable;
use WezomCms\Core\Traits\Model\OrderBySort;
use WezomCms\Core\Traits\Model\PublishedTrait;

/**
 * \WezomCms\Faq\Models\FaqQuestion
 *
 * @property int $id
 * @property bool $published
 * @property int $sort
 * @property int|null $faq_group_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \WezomCms\Faq\Models\FaqGroup|null $group
 * @property-read \WezomCms\Faq\Models\FaqQuestionTranslation $translation
 * @property-read \Illuminate\Database\Eloquent\Collection|\WezomCms\Faq\Models\FaqQuestionTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqQuestion filter($input = array(), $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqQuestion listsTranslations($translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqQuestion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqQuestion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqQuestion notTranslatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqQuestion orWhereTranslation($translationField, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqQuestion orWhereTranslationLike($translationField, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqQuestion orderByTranslation($translationField, $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqQuestion paginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqQuestion published()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqQuestion publishedWithSlug($slug, $slugField = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqQuestion query()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqQuestion simplePaginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqQuestion sorting()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqQuestion translated()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqQuestion translatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqQuestion whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqQuestion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqQuestion whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqQuestion whereFaqGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqQuestion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqQuestion whereLike($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqQuestion whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqQuestion wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqQuestion whereTranslation($translationField, $value, $locale = null, $method = 'whereHas', $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqQuestion whereTranslationLike($translationField, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqQuestion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqQuestion withTranslation()
 * @mixin \Eloquent
 * @mixin FaqQuestionTranslation
 */
class FaqQuestion extends Model
{
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
    protected $fillable = ['published'];

    /**
     * Names of the fields being translated in the "Translation" model.
     *
     * @var array
     */
    protected $translatedAttributes = ['question', 'answer'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['published' => 'bool'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['published_at'];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translation'];

    public $abilityPrefix = 'faq';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(FaqGroup::class, 'faq_group_id');
    }
}
