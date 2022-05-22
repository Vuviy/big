<?php

namespace WezomCms\Localities\Models;

use Illuminate\Database\Eloquent\Model;
use WezomCms\Core\Traits\Model\MultiLanguageSluggableTrait;

class CityTranslation extends Model
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
    protected $fillable = ['name', 'slug'];
}
