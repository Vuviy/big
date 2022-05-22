<?php

namespace WezomCms\BuyOneClick\Http\Livewire;

use Auth;
use Livewire\Component;
use Notification;
use WezomCms\BuyOneClick\Models\BuyOneClick;
use WezomCms\BuyOneClick\Notifications\BuyOneClickNotification;
use WezomCms\Catalog\Models\Product;
use WezomCms\Core\Foundation\Helpers;
use WezomCms\Core\Foundation\JsResponse;
use WezomCms\Core\Models\Administrator;
use WezomCms\Core\Rules\PhoneMask;
use WezomCms\Core\Services\CheckForSpam;
use WezomCms\PrivacyPolicy\PrivacyPolicyServiceProvider;

/**
 * Class Form
 * @package WezomCms\BuyOneClick\Http\Livewire
 * @property bool $privacyPolicyLoaded
 * @property Product $product
 */
class Form extends Component
{
    /**
     * @var int
     */
    public $productId;

    /**
     * @var string|null
     */
    public $name;

    /**
     * @var string|null
     */
    public $phone;

    /**
     * @var string|null
     */
    public $count;

    /**
     * @param  int  $id
     */
    public function mount(int $id)
    {
        $this->productId = $id;

        $this->count = $this->product->minCountForPurchase();

        $user = optional(Auth::user());

        $this->name = $user->full_name;
        $this->phone = $user->masked_phone;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render()
    {
        return view(
            'cms-buy-one-click::site.livewire.form',
            [
                'product' => $this->product,
                'privacyPolicyLoaded' => $this->privacyPolicyLoaded,
            ]
        );
    }

    /**
     * @param $field
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updated($field)
    {
        if (in_array($field, ['name', 'phone'])) {
            $this->validateOnly($field, ...$this->rules());
        }
    }

    public function updatedCount()
    {
        $minCountForPurchase = $this->product->minCountForPurchase();

        if ($this->count < $minCountForPurchase) {
            $this->count = $minCountForPurchase;
        }
    }

    /**
     * Form submit handler
     * @param  CheckForSpam  $checkForSpam
     */
    public function submit(CheckForSpam $checkForSpam)
    {
        if (!$checkForSpam->checkInComponent($this, null, $this->name)) {
            return;
        }

        $this->validate(...$this->rules());

        if (!$this->product->availableForPurchase()) {
            JsResponse::make()
                ->notification(__('cms-buy-one-click::site.Product is not available for purchase'), 'error')
                ->emit($this);

            return;
        }

        try {
            $order = \DB::transaction(function () {
                $order = new BuyOneClick([
                    'count' => $this->count,
                    'name' => $this->name,
                    'phone' => remove_phone_mask($this->phone),
                ]);

                $order->product()->associate($this->productId);
                $order->user()->associate(Auth::id());

                $order->save();

                return $order;
            });

            if ($order) {
                $this->reset('name', 'phone');

                $administrators = Administrator::toNotifications('buy-one-click.edit')->get();
                Notification::send($administrators, new BuyOneClickNotification($order));

                JsResponse::make()
                    ->modal(['content' => view('cms-ui::modals.response-info', [
                        'text' => __('cms-buy-one-click::site.Our manager will contact you shortly')
                    ])->render()])
                    ->emit($this);
            } else {
                JsResponse::make()
                    ->success(false)
                    ->notification(__('cms-buy-one-click::site.Error creating request!'), 'error')
                    ->emit($this);
            }
        } catch (\Throwable $e) {
            report($e);

            JsResponse::make()
                ->success(false)
                ->notification(__('cms-buy-one-click::site.Error creating request!'), 'error')
                ->emit($this);
        }
    }

    public function decreaseCount()
    {
        if ($this->product->canDecreaseQuantity($this->count)) {
            $this->count = $this->count - $this->product->stepForPurchase();
        }
    }

    public function increaseCount()
    {
        $this->count = $this->count + $this->product->stepForPurchase();
    }

    /**
     * @return Product
     */
    public function getProductProperty(): Product
    {
        return Product::published()->findOrFail($this->productId);
    }

    /**
     * @return bool
     */
    public function getPrivacyPolicyLoadedProperty(): bool
    {
        return Helpers::providerLoaded(PrivacyPolicyServiceProvider::class);
    }

    /**
     * @return array
     */
    protected function rules(): array
    {
        return [
            [
//                'count' => [
//                    'required',
//                    'numeric',
//                    "min:{$this->product->minCountForPurchase()}",
//                ],
//                'name' => 'required|string|max:255',
                'phone' => ['required', 'string', 'max:255', new PhoneMask()],
            ],
            [],
            [
                'count' => __('cms-buy-one-click::site.Count'),
                'name' => __('cms-buy-one-click::site.Name'),
                'phone' => __('cms-buy-one-click::site.Phone'),
            ]
        ];
    }
}
