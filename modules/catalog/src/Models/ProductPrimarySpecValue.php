<?php

namespace WezomCms\Catalog\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class ProductPrimarySpecValue extends EloquentModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_primary_spec_value';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
