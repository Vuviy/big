<?php

namespace WezomCms\Orders\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use WezomCms\Localities\Models\City;
use WezomCms\Localities\Models\Locality;
use WezomCms\Orders\Enums\DeliveryDrivers;

class OrderDeliveryInformation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['locality_id', 'delivery_cost', 'street', 'house', 'room', 'ttn'];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function locality(): BelongsTo
    {
        return $this->belongsTo(Locality::class);
    }

    public function getFullDeliveryAddress(string $deliveryDriver, ?string $locale = null): ?string
    {
        switch ($deliveryDriver) {
            case DeliveryDrivers::COURIER:
                $result = sprintf(
                    '%s (%s), %s %s',
                    $this->locality->translate($locale)->name,
                    $this->locality->city->translate($locale)->name,
                    $this->street,
                    $this->house
                );
                if ($this->room) {
                    $result .= ' ' . \Lang::get('cms-orders::' . app('side') . '.room', [], $locale);
                    $result .= ' ' . $this->room;
                }

                return $result;
            default:
                return null;
        }
    }
}
