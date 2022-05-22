<?php

namespace WezomCms\BuyOneClick\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use WezomCms\Catalog\Models\Product;
use WezomCms\Core\Traits\Model\Filterable;
use WezomCms\Users\Models\User;

/**
 * \WezomCms\BuyOneClick\Models\BuyOneClick
 *
 * @property int $id
 * @property int|null $product_id
 * @property float $count
 * @property string|null $name
 * @property string $phone
 * @property bool $read
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id
 * @property-read Product|null $product
 * @property-read User|null $user
 * @method static \WezomCms\BuyOneClick\Database\Factories\BuyOneClickFactory factory(...$parameters)
 * @method static Builder|BuyOneClick filter(array $input = [], $filter = null)
 * @method static Builder|BuyOneClick newModelQuery()
 * @method static Builder|BuyOneClick newQuery()
 * @method static Builder|BuyOneClick paginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static Builder|BuyOneClick query()
 * @method static Builder|BuyOneClick simplePaginateFilter(?int $perPage = null, ?int $columns = [], ?int $pageName = 'page', ?int $page = null)
 * @method static Builder|BuyOneClick whereBeginsWith(string $column, string $value, string $boolean = 'and')
 * @method static Builder|BuyOneClick whereCount($value)
 * @method static Builder|BuyOneClick whereCreatedAt($value)
 * @method static Builder|BuyOneClick whereEndsWith(string $column, string $value, string $boolean = 'and')
 * @method static Builder|BuyOneClick whereId($value)
 * @method static Builder|BuyOneClick whereLike(string $column, string $value, string $boolean = 'and')
 * @method static Builder|BuyOneClick whereName($value)
 * @method static Builder|BuyOneClick wherePhone($value)
 * @method static Builder|BuyOneClick whereProductId($value)
 * @method static Builder|BuyOneClick whereRead($value)
 * @method static Builder|BuyOneClick whereUpdatedAt($value)
 * @method static Builder|BuyOneClick whereUserId($value)
 * @mixin \Eloquent
 */
class BuyOneClick extends Model
{
    use Filterable;
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'buy_one_click';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['read' => 'bool'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['product_id', 'count', 'name', 'phone', 'read'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
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
    public function unit(): string
    {
        return $this->product instanceof \WezomCms\Orders\Contracts\PurchasedProductInterface
            ? $this->product->unit()
            : \Lang::get('cms-buy-one-click::' . app('side') . '.pieces');
    }
}
