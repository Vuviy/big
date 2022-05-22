<?php

namespace WezomCms\Localities\Models;

use Illuminate\Database\Eloquent\Model;
use WezomCms\Core\ExtendPackage\Translatable;
use WezomCms\Core\Traits\Model\Filterable;
use WezomCms\Core\Traits\Model\GetForSelectTrait;
use WezomCms\Core\Traits\Model\OrderBySort;
use WezomCms\Core\Traits\Model\PublishedTrait;

class City extends Model
{
    use Filterable;
    use Translatable;
    use PublishedTrait;
    use GetForSelectTrait;
    use OrderBySort;

    /**
     * Selection options for GetForSelectTrait.
     *
     * @var array
     */
    protected static $selectOptions = ['sort' => ['sort' => 'ASC', 'id' => 'DESC']];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['published', 'index'];

    /**
     * Names of the fields being translated in the "Translation" model.
     *
     * @var array
     */
    protected $translatedAttributes = ['name', 'slug'];

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
    public function localities()
    {
        return $this->hasMany(Locality::class);
    }

    /**
     * @return int
     */
    public function getMinimalCourierShippingCost(): int
    {
        return $this->localities->where('located_within_the_city', false)->min('delivery_cost') ?? 0;
    }
}
