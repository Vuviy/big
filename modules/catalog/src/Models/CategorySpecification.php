<?php

namespace WezomCms\Catalog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use WezomCms\Catalog\Models\Specifications\Specification;

class CategorySpecification extends EloquentModel
{
    use HasFactory;

    protected $table = 'category_specification';

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
    protected $fillable = ['category_id', 'specification_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function specification()
    {
        return $this->belongsTo(Specification::class);
    }
}
