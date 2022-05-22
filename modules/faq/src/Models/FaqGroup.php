<?php

namespace WezomCms\Faq\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use WezomCms\Core\ExtendPackage\Translatable;
use WezomCms\Core\Traits\Model\Filterable;
use WezomCms\Core\Traits\Model\GetForSelectTrait;
use WezomCms\Core\Traits\Model\OrderBySort;
use WezomCms\Core\Traits\Model\PublishedTrait;

/**
 * \WezomCms\Faq\Models\FaqGroup
 *
 * @property int $id
 * @property bool $published
 * @property int $sort
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\WezomCms\Faq\Models\FaqQuestion[] $faqQuestions
 * @property-read int|null $faq_questions_count
 * @property-read \WezomCms\Faq\Models\FaqGroupTranslation $translation
 * @property-read \Illuminate\Database\Eloquent\Collection|\WezomCms\Faq\Models\FaqGroupTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqGroup filter($input = array(), $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqGroup listsTranslations($translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqGroup notTranslatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqGroup orWhereTranslation($translationField, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqGroup orWhereTranslationLike($translationField, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqGroup orderByTranslation($translationField, $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqGroup paginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqGroup published()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqGroup publishedWithSlug($slug, $slugField = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqGroup simplePaginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqGroup sorting()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqGroup translated()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqGroup translatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqGroup whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqGroup whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqGroup whereLike($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqGroup whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqGroup wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqGroup whereTranslation($translationField, $value, $locale = null, $method = 'whereHas', $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqGroup whereTranslationLike($translationField, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqGroup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Faq\Models\FaqGroup withTranslation()
 * @mixin \Eloquent
 * @mixin FaqGroupTranslation
 */
class FaqGroup extends Model
{
    use Translatable;
    use Filterable;
    use HasFactory;
    use GetForSelectTrait;
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
    protected $translatedAttributes = ['name'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['published' => 'bool'];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translation'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function faqQuestions()
    {
        return $this->hasMany(FaqQuestion::class);
    }
}
