<?php

namespace WezomCms\OurTeam\Models;

use Illuminate\Database\Eloquent\Model;


class EmployeeTranslation extends Model
{
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
    protected $fillable = ['name', 'position', 'description'];
}
