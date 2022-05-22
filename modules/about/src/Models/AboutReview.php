<?php

namespace WezomCms\About\Models;

use Illuminate\Database\Eloquent\Model;
use WezomCms\Core\Traits\Model\Filterable;
use WezomCms\Core\Traits\Model\PublishedTrait;


class AboutReview extends Model
{
    use Filterable;
    use PublishedTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'text', 'published' ,'notify'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'published' => 'bool',
        'notify' => 'bool',
    ];
}
