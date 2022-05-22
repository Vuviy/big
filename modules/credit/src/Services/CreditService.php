<?php

namespace WezomCms\Credit\Services;

use Illuminate\Support\Collection;
use WezomCms\Catalog\Models\Product;
use WezomCms\Credit\Banks\HomeCreditBank;
use WezomCms\Credit\Contracts\CreditBankInterface;

class CreditService
{
    /**
     * @var Collection|CreditBankInterface[]
     */
    protected $payments;

    /**
     * CreditService constructor.
     */
    public function __construct()
    {
        $this->payments = collect([
            new HomeCreditBank(),
        ])->filter(function (CreditBankInterface $service) {
            return $service->validate();
        });
    }

    /**
     * @param  Product  $product
     * @param  int|null  $price
     * @param  int|null  $monthCount
     * @return int|null
     */
    public function getMinimumPayment(Product $product, ?int $price = null, ?int $monthCount = null): ?int
    {
        $costs = collect();
        foreach ($this->getPayments() as $payment) {
            $costs->push($payment->minimumPayment($product, $monthCount, $price));
        }

        $costs = $costs->filter();

        return $costs->isEmpty() ? null : $costs->min();
    }

    /**
     * @return Collection|CreditBankInterface[]
     */
    public function getPayments(): Collection
    {
        return $this->payments;
    }

    /**
     * @param  string  $bank
     * @return CreditBankInterface|null
     */
    public function getPayment(string $bank): ?CreditBankInterface
    {
        return $this->payments->first(function (CreditBankInterface $creditBank) use ($bank) {
            return $creditBank::getType() === $bank;
        });
    }
}
