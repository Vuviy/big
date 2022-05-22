<?php

namespace WezomCms\ProductReviews\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use WezomCms\Catalog\Contracts\ReviewRatingInterface;
use WezomCms\Catalog\Models\Product;
use WezomCms\Core\Traits\Model\Filterable;
use WezomCms\Core\Traits\Model\PublishedTrait;
use WezomCms\Users\Models\User;

/**
 * \WezomCms\ProductReviews\Models\ProductReview
 *
 * @property int $id
 * @property bool $published
 * @property int|null $product_id
 * @property int|null $parent_id
 * @property int|null $user_id
 * @property bool $already_bought
 * @property bool $admin_answer
 * @property int $rating
 * @property int $likes
 * @property int $dislikes
 * @property string|null $name
 * @property string|null $email
 * @property string $text
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read string $formatted_date
 * @property-read ProductReview|null $parent
 * @property-read Product|null $product
 * @property-read User|null $user
 * @method static Builder|ProductReview filter(array $input = [], $filter = null)
 * @method static Builder|ProductReview newModelQuery()
 * @method static Builder|ProductReview newQuery()
 * @method static Builder|ProductReview onlyChildren()
 * @method static Builder|ProductReview paginateFilter($perPage = null, $columns = [], $pageName = 'page', $page = null)
 * @method static Builder|ProductReview published()
 * @method static Builder|ProductReview publishedWithSlug($slug, $slugField = 'slug')
 * @method static Builder|ProductReview query()
 * @method static Builder|ProductReview root()
 * @method static Builder|ProductReview simplePaginateFilter(?int $perPage = null, ?int $columns = [], ?int $pageName = 'page', ?int $page = null)
 * @method static Builder|ProductReview top()
 * @method static Builder|ProductReview whereAdminAnswer($value)
 * @method static Builder|ProductReview whereAlreadyBought($value)
 * @method static Builder|ProductReview whereBeginsWith(string $column, string $value, string $boolean = 'and')
 * @method static Builder|ProductReview whereCreatedAt($value)
 * @method static Builder|ProductReview whereDislikes($value)
 * @method static Builder|ProductReview whereEmail($value)
 * @method static Builder|ProductReview whereEndsWith(string $column, string $value, string $boolean = 'and')
 * @method static Builder|ProductReview whereId($value)
 * @method static Builder|ProductReview whereLike(string $column, string $value, string $boolean = 'and')
 * @method static Builder|ProductReview whereLikes($value)
 * @method static Builder|ProductReview whereName($value)
 * @method static Builder|ProductReview whereParentId($value)
 * @method static Builder|ProductReview whereProductId($value)
 * @method static Builder|ProductReview wherePublished($value)
 * @method static Builder|ProductReview whereRating($value)
 * @method static Builder|ProductReview whereText($value)
 * @method static Builder|ProductReview whereUpdatedAt($value)
 * @method static Builder|ProductReview whereUserId($value)
 * @mixin \Eloquent
 */
class ProductReview extends Model implements ReviewRatingInterface
{
    use Filterable;
    use PublishedTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'published', 'product_id', 'parent_id', 'user_id', 'already_bought', 'admin_answer', 'rating', 'likes',
        'dislikes', 'name', 'email', 'text', 'notify'
    ];

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'likes' => 0,
        'dislikes' => 0,
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['published' => 'bool', 'already_bought' => 'bool', 'admin_answer' => 'bool', 'notify' => 'bool'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(ProductReview::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function childes()
    {
        return $this->hasMany(ProductReview::class, 'parent_id', 'id');
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
    public function getFormattedDateAttribute(): string
    {
        return sprintf(
            '%d %s %d',
            $this->created_at->format('d'),
            $this->created_at->getTranslatedMonthName('Do MMMM'),
            $this->created_at->format('Y')
        );
    }

    /**
     * @return int
     */
    public function getRating(): int
    {
        return $this->rating;
    }

    /**
     * @param  int  $rating
     * @return $this
     */
    public function setRating(int $rating)
    {
        $this->rating = $rating;

        $this->save();

        return $this;
    }

    /**
     * @param $query
     */
    public function scopeRoot($query)
    {
        $query->whereNull('parent_id')->where('admin_answer', false);
    }

    /**
     * @param $query
     */
    public function scopeOnlyChildren($query)
    {
        $query->whereNotNull('parent_id');
    }

    /**
     * @param $query
     */
    public function scopeTop($query)
    {
        $query->orderByRaw('CAST(`likes` AS SIGNED) - CAST(`dislikes` AS SIGNED) DESC')
            ->orderByDesc('likes');
    }

    public static function getForFront(int $productId)
    {
        return static::where('product_id', $productId)
            ->root()
            ->published()
            ->with(['childes' => function ($q) {
                $q->published()->orderByDesc('created_at')->latest('id');
            }])
            ->orderByDesc('created_at')
            ->latest('id')
            ->paginate(settings('product-reviews.site.product_page_limit', 10));
    }
}
