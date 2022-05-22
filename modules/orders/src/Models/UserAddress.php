<?php

namespace WezomCms\Orders\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Lang;
use WezomCms\Core\Traits\Model\Filterable;
use WezomCms\Localities\Models\Locality;
use WezomCms\Users\Models\User;

class UserAddress extends Model
{
    use Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['primary', 'user_id', 'locality_id', 'street', 'house', 'room'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['primary' => 'bool'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function locality(): BelongsTo
    {
        return $this->belongsTo(Locality::class);
    }

    /**
     * @return string
     */
    public function getFullAddressAttribute()
    {
        $parts = [
            $this->locality->full_name,
            $this->street,
            Lang::get('cms-orders::' . app('side') . '.house') . ' ' . $this->house,
            $this->room ? Lang::get('cms-orders::' . app('side') . '.room') . ' ' . $this->room : null,
        ];

        return implode(', ', array_filter($parts));
    }
}
