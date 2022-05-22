<?php

namespace WezomCms\Users\Models;

use Eloquent;
use Exception;
use Greabock\Tentacles\EloquentTentacle;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use WezomCms\Core\Foundation\Helpers;
use WezomCms\Core\Traits\Model\Filterable;
use WezomCms\Orders\Models\Communication;
use WezomCms\Orders\Models\UserAddress;
use WezomCms\Users\Notifications\ResetPassword;
use WezomCms\Users\Notifications\ResetPasswordByCode;
use WezomCms\Users\Notifications\VerifyAccount;

/**
 * \WezomCms\Users\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $email_verified_at
 * @property string|null $registered_through
 * @property string $password
 * @property bool $active
 * @property  $communication
 * @property  Carbon|null $birthday
 * @property string|null $remember_token
 * @property int|null $temporary_code
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read string|string[]|null $clear_phone
 * @property-read string $full_name
 * @property-read string $masked_phone
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read Collection|SocialAccount[] $socialAccounts
 * @property-read Collection|UserAddress[] $addresses
 * @method static Builder|User filter($input = array(), $filter = null)
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User paginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static Builder|User query()
 * @method static Builder|User simplePaginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static Builder|User whereBeginsWith($column, $value, $boolean = 'and')
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereEndsWith($column, $value, $boolean = 'and')
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereLike($column, $value, $boolean = 'and')
 * @method static Builder|User whereName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User wherePhone($value)
 * @method static Builder|User whereRegisteredThrough($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereActive($value)
 * @method static Builder|User whereSurname($value)
 * @method static Builder|User whereTemporaryCode($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @mixin Eloquent
 * @method static Builder|User whereManagerId($value)
 * @method static Builder|User active()
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use Filterable;
    use HasFactory;
    use Notifiable;
    use EloquentTentacle;

    public const EMAIL = 'email';
    public const PHONE = 'phone';
    public const TEMPORARY_CODE_LENGTH = 4;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['active', 'name', 'surname', 'email', 'phone', 'registered_through', 'password', 'birthday', 'communication'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['active' => 'bool'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['birthday'];

    public static function emailOrPhone($value): string
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) ? User::EMAIL : User::PHONE;
    }

    public static function search(string $search = null, int $limit = 10): LengthAwarePaginator
    {
        $query = User::query();

        if ($search) {
            $query->orWhere(function ($query) use ($search) {
                $query->where('name', 'LIKE', '%' . Helpers::escapeLike($search) . '%')
                    ->orWhere('surname', 'LIKE', '%' . Helpers::escapeLike($search) . '%');
            });
        }

        return $query->paginate($limit);
    }

    /**
     * @return mixed
     */
    public function socialAccounts()
    {
        return $this->hasMany(SocialAccount::class);
    }

    /**
     * @param Builder $query
     */
    public function scopeActive(Builder $query)
    {
        $query->where('active', true);
    }

    public function sendEmailVerificationNotification(): void
    {
        try {
            $this->notify(new VerifyAccount());
        } catch (Exception $e) {
            logger('sendEmailVerificationNotification exception', [
                'action' => 'Send the email verification notification',
                'user' => $this->id,
                'message' => $e->getMessage(),
            ]);

            // If there was an error sending SMS - mark user as verified.
            if ($this->markEmailAsVerified()) {
                event(new Verified($this));
            }
        }
    }

    public function markEmailAsVerified(): bool
    {
        return $this->forceFill([
            'email_verified_at' => $this->freshTimestamp(),
            'temporary_code' => null,
        ])->save();
    }

    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPassword($token));
    }

    public function sendPasswordResetByCodeNotification(): bool
    {
        try {
            $this->notify(new ResetPasswordByCode());

            return true;
        } catch (Exception $e) {
            logger('sendPasswordResetByCodeNotification exception', [
                'action' => 'Send the password reset notification',
                'user' => $this->id,
                'message' => $e->getMessage(),
            ]);

            return false;
        }
    }

    public function routeNotificationForTurboSms(): ?string
    {
        return $this->phone;
    }

    public function routeNotificationForESputnik(): ?string
    {
        return $this->phone;
    }

    public function generateTemporaryCode(): ?bool
    {
        $length = User::TEMPORARY_CODE_LENGTH;
        $this->temporary_code = mt_rand(1 . str_repeat(0, $length - 1), str_repeat(9, $length));

        return $this->save();
    }

    public function getFullNameAttribute(): string
    {
        return trim("{$this->name} {$this->surname}");
    }

    /**
     * @return string|string[]|null
     */
    public function getClearPhoneAttribute()
    {
        return remove_phone_mask($this->phone);
    }

    public function getMaskedPhoneAttribute(): string
    {
        return apply_phone_mask($this->phone);
    }

    public static function communicationTypes() : array
    {
        return Communication::published()
            ->with('translation:name')
            ->get()
            ->pluck('name', 'driver')
            ->toArray();
    }

    public function selectedCommunications(): array
    {
        return $this->communication ? json_decode($this->communication) : [];
    }

    public function addresses() : HasMany
    {
        return $this->hasMany(UserAddress::class);
    }
}
