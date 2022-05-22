<?php

namespace WezomCms\Orders\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * \WezomCms\Orders\Models\OrderRecipient
 *
 * @property int $id
 * @property int $order_id
 * @property bool $recipient_is_me
 * @property string|null $name
 * @property string|null $surname
 * @property string|null $patronymic
 * @property string|null $phone
 * @property string|null $comment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $full_name
 * @property-read \WezomCms\Orders\Models\Order|null $order
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRecipient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRecipient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRecipient query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRecipient whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRecipient whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRecipient whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRecipient whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRecipient whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRecipient wherePatronymic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRecipient wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRecipient whereRecipientIsMe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRecipient whereSurname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderRecipient whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OrderRecipient extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['recipient_is_me', 'name', 'surname', 'patronymic', 'phone', 'comment'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = ['recipient_is_me' => 'bool'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function order()
    {
        return $this->hasOne(Order::class);
    }

    /**
     * @return string
     */
    public function getFullNameAttribute()
    {
        return implode(' ', [$this->surname, $this->name, $this->patronymic]);
    }
}
