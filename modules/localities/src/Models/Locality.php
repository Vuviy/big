<?php

namespace WezomCms\Localities\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use WezomCms\Core\ExtendPackage\Translatable;
use WezomCms\Core\Traits\Model\Filterable;
use WezomCms\Core\Traits\Model\GetForSelectTrait;
use WezomCms\Core\Traits\Model\OrderBySort;
use WezomCms\Core\Traits\Model\PublishedTrait;

class Locality extends Model
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
    protected $fillable = ['published', 'delivery_cost', 'located_within_the_city'];

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = ['delivery_cost' => 0];

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
    protected $casts = ['published' => 'bool', 'located_within_the_city' => 'bool'];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translation'];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function getFullNameAttribute(): string
    {
        return sprintf('%s (%s)', $this->name, $this->city->name);
    }
}
