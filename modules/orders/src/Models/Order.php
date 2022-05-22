<?php

namespace WezomCms\Orders\Models;

use Cache;
use Greabock\Tentacles\EloquentTentacle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use WezomCms\Core\Traits\Model\Filterable;
use WezomCms\Orders\Contracts\Payment\OnlinePaymentInterface;
use WezomCms\Users\Models\User;

/**
 * \WezomCms\Orders\Models\Order
 *
 * @property int $id
 * @property int|null $delivery_id
 * @property int|null $payment_id
 * @property int|null $status_id
 * @property int|null $user_id
 * @property bool $payed
 * @property bool $dont_call_back
 * @property string|null $payed_mode
 * @property \Illuminate\Support\Carbon|null $payed_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \WezomCms\Orders\Models\OrderClient|null $client
 * @property-read \WezomCms\Orders\Models\Delivery|null $delivery
 * @property-read string|null $delivery_address
 * @property-read \WezomCms\Orders\Models\OrderDeliveryInformation|null $deliveryInformation
 * @property-read \WezomCms\Orders\Models\OrderPaymentInformation|null $paymentInformation
 * @property-read string $currency_iso_code
 * @property-read mixed $discount
 * @property-read string $quantity
 * @property-read float $whole_purchase_price
 * @property-read \Illuminate\Database\Eloquent\Collection|\WezomCms\Orders\Models\OrderItem[] $items
 * @property-read int|null $items_count
 * @property-read \WezomCms\Orders\Models\Payment|null $payment
 * @property-read \WezomCms\Orders\Models\OrderRecipient|null $recipient
 * @property-read \WezomCms\Orders\Models\OrderStatus|null $status
 * @property-read \Illuminate\Database\Eloquent\Collection|\WezomCms\Orders\Models\OrderStatus[] $statusHistory
 * @property-read int|null $status_history_count
 * @property-read User|null $user
 * @method static Builder|Order filter(array $input = [], $filter = null)
 * @method static Builder|Order new()
 * @method static Builder|Order newModelQuery()
 * @method static Builder|Order newQuery()
 * @method static Builder|Order onlyTrashed()
 * @method static Builder|Order paginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static Builder|Order query()
 * @method static Builder|Order simplePaginateFilter(?int $perPage = null, ?int $columns = [], ?int $pageName = 'page', ?int $page = null)
 * @method static Builder|Order whereBeginsWith(string $column, string $value, string $boolean = 'and')
 * @method static Builder|Order whereCreatedAt($value)
 * @method static Builder|Order whereDeletedAt($value)
 * @method static Builder|Order whereDeliveryId($value)
 * @method static Builder|Order whereDiscountType($value)
 * @method static Builder|Order whereDontCallBack($value)
 * @method static Builder|Order whereEndsWith(string $column, string $value, string $boolean = 'and')
 * @method static Builder|Order whereId($value)
 * @method static Builder|Order whereLike(string $column, string $value, string $boolean = 'and')
 * @method static Builder|Order wherePayed($value)
 * @method static Builder|Order wherePayedAt($value)
 * @method static Builder|Order wherePayedMode($value)
 * @method static Builder|Order wherePaymentId($value)
 * @method static Builder|Order wherePromoCodeAmount($value)
 * @method static Builder|Order wherePromoCodeId($value)
 * @method static Builder|Order whereStatusId($value)
 * @method static Builder|Order whereUpdatedAt($value)
 * @method static Builder|Order whereUserId($value)
 * @method static Builder|Order withTrashed()
 * @method static Builder|Order withoutTrashed()
 * @mixin \Eloquent
 */
class Order extends Model
{
    use Filterable;
    use SoftDeletes;
    use EloquentTentacle;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['dont_call_back'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['payed' => 'bool', 'dont_call_back' => 'bool'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['payed_at'];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['items', 'items.product.mainImage', 'status', 'statusHistory', 'user', 'recipient', 'client',
        'deliveryInformation', 'paymentInformation', 'deliveryInformation.locality.city'];

    /**
     * @param  Builder|Order  $query
     */
    public function scopeNew(Builder $query)
    {
        $query->whereStatusId(OrderStatus::NEW);
    }

    /**
     * @param $value
     */
    public function setPayedAttribute($value)
    {
        $value = $this->castAttribute('payed', $value);

        if ($value !== $this->payed) {
            $this->attributes['payed_at'] = $value ? now() : null;
        }

        $this->attributes['payed'] = $value;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo(OrderStatus::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function delivery()
    {
        return $this->belongsTo(Delivery::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function deliveryInformation()
    {
        return $this->hasOne(OrderDeliveryInformation::class);
    }

    public function paymentInformation()
    {
        return $this->hasOne(OrderPaymentInformation::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function client()
    {
        return $this->hasOne(OrderClient::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function recipient()
    {
        return $this->hasOne(OrderRecipient::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return string
     */
    public function getCurrencyIsoCodeAttribute()
    {
        return 'UAH';
    }

    /**
     * @param  OrderStatus|null  $status
     * @return Order
     */
    public function changeStatus(?OrderStatus $status)
    {
        $this->status()->associate($status);

        if ($this->isDirty('status_id')) {
            $this->statusHistory()->attach($status->id);
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getOnlinePaymentUrl(): ?string
    {
        return optional($this->getOnlinePaymentDriver())->redirectUrl($this);
    }

    /**
     * @return OnlinePaymentInterface|null
     */
    public function getOnlinePaymentDriver(): ?OnlinePaymentInterface
    {
        if ($this->payed || round($this->whole_purchase_price, money()->precision()) == 0) {
            return null;
        }

        $payment = $this->payment;
        if (!$payment || !$payment->driver) {
            return null;
        }

        $paymentDriver = $payment->makeDriver();
        if (!$paymentDriver || !$paymentDriver instanceof OnlinePaymentInterface) {
            return null;
        }

        return $paymentDriver;
    }

    /**
     * @return string|null
     */
    public function paymentCallbackUrl(): ?string
    {
        $payment = $this->payment;
        if (!$payment || !$payment->driver) {
            return null;
        }

        return route('payment-callback', [$this->id, $payment->driver]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function statusHistory()
    {
        return $this->belongsToMany(OrderStatus::class, 'order_status_history', 'order_id', 'status_id')
            ->withPivot('created_at')
            ->orderBy('order_status_history.created_at');
    }

    /**
     * @return string|null
     */
    public function getDeliveryAddressAttribute(): ?string
    {
        return optional($this->delivery, function (Delivery $delivery) {
            return optional($delivery->makeDriver())->presentDeliveryAddress($this->deliveryInformation);
        });
    }

    /**
     * @return float
     */
    public function getWholePurchasePriceAttribute()
    {
        return $this->items->sum('whole_purchase_price')  + $this->deliveryInformation->delivery_cost;
    }

    /**
     * @return float
     */
    public function getWholePriceAttribute()
    {
        return $this->items->sum('whole_price');
    }

    /**
     * @return string
     */
    public function getQuantityAttribute()
    {
        return $this->items->count();
    }

    /**
     * @return mixed
     */
    public function getDiscountAttribute()
    {
        return $this->items->sum('discount');
    }

    /**
     * @return string
     */
    public function thanksPageUrl(): string
    {
        return route('thanks-page', $this->id);
    }
}
