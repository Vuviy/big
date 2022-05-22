<?php

namespace WezomCms\Orders\Models;

use Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use WezomCms\Credit\Contracts\CreditBankInterface;

/**
 * \WezomCms\Orders\Models\OrderPaymentInformation
 *
 * @property int $id
 * @property int $order_id
 * @property string|null $ipn
 * @property int|null $repayment_period срок погашения кредита
 * @property string|null $bank
 * @property string|null $company_name
 * @property string|null $company_address
 * @property int|null $bin
 * @property string|null $bik
 * @property string|null $iik
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $invoice_id
 * @property-read \WezomCms\Orders\Models\Order $order
 * @property-read string $invoice_buyer
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPaymentInformation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPaymentInformation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPaymentInformation query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPaymentInformation whereBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPaymentInformation whereBik($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPaymentInformation whereBin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPaymentInformation whereCompanyAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPaymentInformation whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPaymentInformation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPaymentInformation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPaymentInformation whereIik($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPaymentInformation whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPaymentInformation whereIpn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPaymentInformation whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPaymentInformation whereRepaymentPeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPaymentInformation whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $redirect_url
 * @method static \Illuminate\Database\Eloquent\Builder|OrderPaymentInformation whereRedirectUrl($value)
 */
class OrderPaymentInformation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ipn',
        'repayment_period',
        'bank',
        'bank_status',
        'bank_order_no',
        'bank_contract_code',
        'bank_product_code',
        'redirect_url',
    ];

    /**
     * Associative array with custom banks.
     *
     * @var array
     */
    protected static $banks = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function makeBank(array $arguments = [], $namespace = 'WezomCms\\Credit\\Banks'): ?CreditBankInterface
    {
        if (!$this->bank) {
            return null;
        }

        return Cache::driver('array')
            ->rememberForever("bank-{$this->bank}", function () use ($namespace, $arguments) {
                if (array_key_exists($this->bank, static::$banks)) {
                    $fullClassName = static::$banks[$this->bank];
                } else {
                    $fullClassName = (string)Str::of($namespace)
                        ->rtrim('\\')
                        ->append('\\', Str::studly($this->bank));
                }

                return class_exists($fullClassName) ? app($fullClassName, $arguments) : null;
            });
    }
}
