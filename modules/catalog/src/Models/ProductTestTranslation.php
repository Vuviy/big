<?php

namespace WezomCms\Catalog\Models;

use Illuminate\Database\Eloquent\Model;
use WezomCms\Core\Traits\Model\MultiLanguageSluggableTrait;

/**
 * \WezomCms\Catalog\Models\ProductTranslation
 *
 * @property int $id
 * @property int $product_id
 * @property string $name
 * @property string $slug
 * @property string|null $text
 * @property string|null $title
 * @property string|null $h1
 * @property string|null $keywords
 * @property string|null $description
 * @property string $locale
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\ProductTranslation findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\ProductTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\ProductTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\ProductTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\ProductTranslation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\ProductTranslation whereH1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\ProductTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\ProductTranslation whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\ProductTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\ProductTranslation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\ProductTranslation whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\ProductTranslation whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\ProductTranslation whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\WezomCms\Catalog\Models\ProductTranslation whereTitle($value)
 * @mixin \Eloquent
 */
class ProductTestTranslation extends Model
{
    use MultiLanguageSluggableTrait;

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
    protected $fillable = ['prodact_test_id','locale', 'name', 'slug', 'text', 'title', 'h1', 'keywords', 'description'];
}
