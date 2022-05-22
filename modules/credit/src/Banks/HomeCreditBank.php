<?php

namespace WezomCms\Credit\Banks;

use Http;
use Illuminate\Support\Collection;
use WezomCms\Catalog\Models\Product;
use WezomCms\Core\Contracts\Assets\AssetManagerInterface;
use WezomCms\Credit\Bank;
use WezomCms\Credit\Contracts\CreditBankInterface;
use WezomCms\Credit\Contracts\CreditBankSendsRequestsInterface;
use WezomCms\Credit\Contracts\CreditBankSendsStatusesToBankInterface;
use WezomCms\Credit\Enums\CreditType;
use WezomCms\Credit\Enums\HomeCreditApplicationStatuses;
use WezomCms\Credit\Exceptions\EmptyHomeCreditCredentialsException;
use WezomCms\Credit\Models\HomeCreditCoefficient;
use WezomCms\Orders\Enums\DeliveryDrivers;
use WezomCms\Orders\Models\Order;
use WezomCms\Orders\Models\OrderItem;
use WezomCms\Orders\Models\OrderPaymentInformation;

class HomeCreditBank extends AbstractBank implements CreditBankInterface, CreditBankSendsRequestsInterface, CreditBankSendsStatusesToBankInterface
{
    protected const DATA_LOCALE = 'ru';

    protected const BASE_API_URL = 'https://e-loan.homecredit.kz/rest/requests';
    protected const TEST_BASE_API_URL = 'https://e-loan-test.homecredit.kz/rest/requests';

    public function __construct()
    {
        $this->loadCoefficients();
    }

    /**
     * @return string
     */
    public static function getType(): string
    {
        return 'home_credit_bank';
    }

    /**
     * Отправляет заявку на кредит в банк
     */
    public function sendRequestToService(Order $order)
    {
        try {
            $response = static::post('create', $this->dataToService($order, $order->thanksPageUrl()));

            if (!$response->ok()) {
                logger('Failed request to home credit bank', [
                    'order_id' => $order->id,
                    'body' => $response->body(),
                    'headers' => $response->headers()
                ]);

                return;
            }

            if ((int)array_get($response->json(), 'attributes.error_code') !== 0) {
                logger('Home credit bank return error code', [
                    'order_id' => $order->id,
                    'code' => array_get($response->json(), 'attributes.error_code'),
                    'body' => $response->body()
                ]);

                return;
            }

            $order->paymentInformation->redirect_url = array_get($response->json(), 'attributes.url');
            $order->paymentInformation->save();
        } catch (EmptyHomeCreditCredentialsException $e) {
            logger(__CLASS__ . __METHOD__, ['message' => $e->getMessage()]);
        } catch (\Throwable $e) {
            logger(__CLASS__ . __METHOD__, ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        }
    }

    /**
     * Generate link to credit system.
     *
     * @param Order $order
     * @return string|null
     */
    public function redirectUrl(Order $order): ?string
    {
        return $order->paymentInformation->redirect_url;
    }

    protected function dataToService(Order $order, string $resultUrl): array
    {
        $data = [
            'order_no' => $order->id,
            'loan_length' => $order->paymentInformation->repayment_period,
            'sales_place' => $order->deliveryInformation->locality->city->index,
            'iin' => $order->paymentInformation->ipn,
            'firstname' => $order->client->name,
            'lastname' => $order->client->surname,
            'email' => $order->client->email,
            'redirect_url' => $resultUrl,
        ];

        if ($order->client->phone) {
            $data['mobile_number'] = preg_replace('/^\+7/', '', $order->client->phone);
        }

        if ($order->delivery->driver === DeliveryDrivers::COURIER) {
            $data['is_delivery'] = 1;
            $data['delivery_address'] = $order->deliveryInformation->getFullDeliveryAddress($order->delivery->driver, static::DATA_LOCALE);
        } else {
            $data['is_delivery'] = 0;
            $data['goods_point_address'] = array_fill(
                0,
                $order->items->count(),
                ['address_line' => $order->deliveryInformation->getFullDeliveryAddress($order->delivery->driver, static::DATA_LOCALE)]
            );
        }

        $amount = 0;

        $products = $order->items->map(function (OrderItem $item) use ($order, &$amount) {
            $price = $item->whole_purchase_price;
            $amount += $price;

            return [
                'commodity_type' => optional($item->product->category)->getTranslation(static::DATA_LOCALE)->name,
                'producer' => isset($item->product->model) ? $item->product->model->getTranslation(static::DATA_LOCALE)->name : '',
                'price' => round($price),
                'model' => $item->product->getTranslation(static::DATA_LOCALE)->name,
                'image' => $item->product->getImageUrl('big'),
            ];
        });

        $data['good'] = $products->values()->all();
        $data['amount'] = round($amount);

        return $data;
    }

    protected function loadCoefficients()
    {
        $this->coefficients = HomeCreditCoefficient::published()->sorting()->get();
    }

    protected function makeBank($coefficient, $price): Bank
    {
        $bank = new Bank();
        $bank->type = $this->getType();
        $bank->name = __('cms-credit::site.Home Credit Bank');
        $bank->logo = app(AssetManagerInterface::class)->addVersion(image_url('images/credit/home-credit-bank.png'));
        $bank->label = CreditType::getDescription($coefficient->type);
        $bank->monthlyPayment = $this->calcMonthlyPayment($coefficient, $price);

        return $bank;
    }

    protected static function post(string $uri, array $data): \Illuminate\Http\Client\Response
    {
        $isTest = settings('home-credit.site.test', 1);
        $data['partner_id'] = settings('home-credit.site.partner_id');
        $data['access_token'] = settings('home-credit.site.access_token');

        if (empty($data['partner_id']) || empty($data['access_token'])) {
            throw new EmptyHomeCreditCredentialsException('Empty home credit bank credentials!');
        }

        logger(__CLASS__ . __METHOD__, ['data' => $data]);

        return Http::baseUrl($isTest ? static::TEST_BASE_API_URL : static::BASE_API_URL)
            ->acceptJson()
            ->post($uri, $data);
    }

    protected function calcMonthlyPayment($coefficient, $price): float
    {
        return round($coefficient->coefficient * $price);
    }

    public function validate(): bool
    {
        return true;
    }

    public function monthCount(Collection $items, $price = null): Collection
    {
        $price = $price ?? $items->map([$this, 'extractProduct'])->sum('price');

        return $this->coefficients->where('availability', '<=', $price)
            ->where('max_sum', '>=', $price)
            ->pluck('month')
            ->sort();
    }

    public function bank(Collection $items, int $month): ?Bank
    {
        $price = $price ?? $items->map([$this, 'extractProduct'])->sum('price');

        $coefficient = $this->coefficients->where('availability', '<=', $price)
            ->where('max_sum', '>=', $price)
            ->where('month', $month)
            ->first();

        return $coefficient ? $this->makeBank($coefficient, $price) : null;
    }

    public function minimumPayment(Product $product, ?int $month = null, $price = null): ?float
    {
        $price = $price ?? $this->extractProduct($product)['price'];

        $coefficient = $this->coefficients->where('availability', '<=', $price)
            ->where('max_sum', '>=', $price)
            ->when($month, function (Collection $collection, $month) {
                return $collection->where('month', $month);
            })
            ->sortBy('coefficient')
            ->first();

        if (!$coefficient) {
            return null;
        }

        return $this->calcMonthlyPayment($coefficient, $price);
    }

    public function saveBankRequest(Order $order, array $requestData)
    {
        $order->paymentInformation->update([
            'bank_order_no' => array_get($requestData, 'orderNo'), // номер заявки в банке
            'bank_contract_code' => array_get($requestData, 'contractCode'), // номер договора в банке
            'repayment_period' => array_get($requestData, 'productTerm'), // срок кредита в банке
            'bank_product_code' => array_get($requestData, 'productCode'), // код продукта в банке
            'bank_status' => array_get($requestData, 'status') // статус заявки в банке,
        ]);
    }

    public function renderAdminFormStatusChangingButtons(OrderPaymentInformation $orderPaymentInformation)
    {
        return view('cms-credit::admin.home-credit-status-buttons.buttons', [
            'orderPaymentInformation' => $orderPaymentInformation,
            'bank' => $this,
        ]);
    }

    /**
     * Можно ли инициировать выдачу товара покупателю
     */
    public static function canSendDeliveredStatus(OrderPaymentInformation $orderPaymentInformation)
    {
        $status = $orderPaymentInformation->bank_status;

        if (!empty($status) &&
            ($status === HomeCreditApplicationStatuses::SIGNED || $status === HomeCreditApplicationStatuses::SIGN_EDS)) {
            return true;
        }

        return false;
    }

    /**
     * Можно ли инициировать отмену заявки на кредит
     */
    public static function canSendCanceledStatus(OrderPaymentInformation $orderPaymentInformation)
    {
        $status = $orderPaymentInformation->bank_status;

        if ($status === HomeCreditApplicationStatuses::PARTNER_CANCELLED ||
            $status === HomeCreditApplicationStatuses::CANCELLED ||
            $status === HomeCreditApplicationStatuses::REJECTED) {
            return false;
        }

        if ($status !== HomeCreditApplicationStatuses::SIGNED &&
            $status !== HomeCreditApplicationStatuses::SIGN_EDS &&
            $status !== HomeCreditApplicationStatuses::DELIVERED) {
            return true;
        }

        return false;
    }

    /**
     * Отправляет статус в банк
     */
    public static function sendStatusToBank(OrderPaymentInformation $orderPaymentInformation, string $status)
    {
        try {
            static::validateStatusesBeforeSendingToBank($orderPaymentInformation, $status);

            $response = static::post('send-result', [
                'order_no' => $orderPaymentInformation->order_id,
                'status' => $status,
            ]);

            logger(__CLASS__ . __METHOD__, [
                'order_id' => $orderPaymentInformation->order_id,
                'status' => $response->status(),
                'json_body' => $response->json(),
                'headers' => $response->headers()
            ]);

            if (!$response->ok()) {
                flash(__('cms-credit::admin.Failed to change the status of the application in the bank'), 'error');
                return;
            }

            if ((int)array_get($response->json(), 'error_code') !== 0) {
                flash(__('cms-credit::admin.Failed to change the status of the application in the bank'), 'error');
                return;
            }

            static::handleSuccessStatusesChanging($orderPaymentInformation, $status);
        } catch (EmptyHomeCreditCredentialsException $e) {
            logger(__CLASS__ . __METHOD__, ['message' => $e->getMessage()]);
        } catch (\Throwable $e) {
            logger(__CLASS__ . __METHOD__, ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            flash(__('cms-credit::admin.Failed to change the status of the application in the bank'), 'error');
        }
    }


    protected static function validateStatusesBeforeSendingToBank($orderPaymentInformation, $status)
    {
        if (!in_array($status, HomeCreditApplicationStatuses::PARTNER_CAN_SEND_STATUSES)) {
            throw new \Exception('Not valid status for sending to the bank!');
        }

        if ($status === HomeCreditApplicationStatuses::PARTNER_CANCELLED) {
            if (!static::canSendCanceledStatus($orderPaymentInformation)) {
                flash(__('cms-credit::admin.You cannot change the status of this application'), 'error');
                return;
            }
        }

        if ($status === HomeCreditApplicationStatuses::DELIVERED) {
            if (!static::canSendDeliveredStatus($orderPaymentInformation)) {
                flash(__('cms-credit::admin.You cannot change the status of this application'), 'error');
                return;
            }
        }
    }

    protected static function handleSuccessStatusesChanging($orderPaymentInformation, $status)
    {
        $orderPaymentInformation->bank_status = $status;
        $orderPaymentInformation->save();

        if ($status === HomeCreditApplicationStatuses::PARTNER_CANCELLED) {
            flash()->success(__('cms-credit::admin.Success! Loan application canceled'));
            return;
        }

        if ($status === HomeCreditApplicationStatuses::DELIVERED) {
            flash()->success(__('cms-credit::admin.Success! The goods can be issued to the client'));
            return;
        }
    }
}
