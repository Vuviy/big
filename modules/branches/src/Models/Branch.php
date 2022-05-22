<?php

namespace WezomCms\Branches\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use WezomCms\Core\ExtendPackage\Translatable;
use WezomCms\Core\Traits\Model\Filterable;
use WezomCms\Core\Traits\Model\GetForSelectTrait;
use WezomCms\Core\Traits\Model\OrderBySort;
use WezomCms\Core\Traits\Model\PublishedTrait;

/**
 * \WezomCms\Branches\Models\Branch
 *
 * @property int $id
 * @property bool $published
 * @property array|null $phones
 * @property string|null $email
 * @property array|null $map
 * @property int $sort
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read BranchTranslation $translation
 * @property-read Collection|BranchTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static Builder|Branch filter($input = array(), $filter = null)
 * @method static Builder|Branch listsTranslations($translationField)
 * @method static Builder|Branch newModelQuery()
 * @method static Builder|Branch newQuery()
 * @method static Builder|Branch notTranslatedIn($locale = null)
 * @method static Builder|Branch orWhereTranslation($translationField, $value, $locale = null)
 * @method static Builder|Branch orWhereTranslationLike($translationField, $value, $locale = null)
 * @method static Builder|Branch orderByTranslation($translationField, $sortMethod = 'asc')
 * @method static Builder|Branch paginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static Builder|Branch published()
 * @method static Builder|Branch publishedWithSlug($slug, $slugField = 'slug')
 * @method static Builder|Branch query()
 * @method static Builder|Branch simplePaginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static Builder|Branch sorting()
 * @method static Builder|Branch translated()
 * @method static Builder|Branch translatedIn($locale = null)
 * @method static Builder|Branch whereBeginsWith($column, $value, $boolean = 'and')
 * @method static Builder|Branch whereCreatedAt($value)
 * @method static Builder|Branch whereEmail($value)
 * @method static Builder|Branch whereEndsWith($column, $value, $boolean = 'and')
 * @method static Builder|Branch whereId($value)
 * @method static Builder|Branch whereLike($column, $value, $boolean = 'and')
 * @method static Builder|Branch whereMap($value)
 * @method static Builder|Branch wherePhones($value)
 * @method static Builder|Branch wherePublished($value)
 * @method static Builder|Branch whereSort($value)
 * @method static Builder|Branch whereTranslation($translationField, $value, $locale = null, $method = 'whereHas', $operator = '=')
 * @method static Builder|Branch whereTranslationLike($translationField, $value, $locale = null)
 * @method static Builder|Branch whereUpdatedAt($value)
 * @method static Builder|Branch withTranslation()
 * @mixin \Eloquent
 * @mixin BranchTranslation
 */
class Branch extends Model
{
    use HasFactory;
    use Translatable;
    use Filterable;
    use GetForSelectTrait;
    use PublishedTrait;
    use OrderBySort;

    /**
     * Names of the fields being translated in the "Translation" model.
     *
     * @var array
     */
    public $translatedAttributes = ['name', 'address', 'schedule'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['published', 'phones', 'email', 'map', 'published', 'sort'];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translation'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'published' => 'bool',
        'phones' => 'array',
        'map' => 'array',
    ];
}
