<?php

namespace WezomCms\Users\Http\Livewire\Cabinet;

use Auth;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;
use Throwable;
use WezomCms\Core\Foundation\JsResponse;
use WezomCms\Core\Services\CheckForSpam;
use WezomCms\Localities\Models\Locality;
use WezomCms\Users\Dto\UserAddressesDto;
use WezomCms\Orders\Models\UserAddress;
use WezomCms\Users\Services\UserAddressesService;


class EditAddresses extends Component
{
    public $addresses;
    public $dbAddresses;
    public $updateMode = true;
    public $primary;
    public $i = 0;
    public $submitDisabled = true;

    protected $service;

    protected $addrTemplate = [
        'address' => '',
        'locality_id' => '',
        'street' => '',
        'house' => '',
        'room' => null,
    ];

    public function mount()
    {
        $this->addresses = $this->dbAddresses = Auth::user()
            ->addresses()
            ->orderBy('id')
            ->get()
            ->toArray();

        if (empty($this->addresses)) {
            $this->addresses[] = $this->addrTemplate;
        }
        $this->primary();

        $this->i = count($this->addresses);
    }

    public function primary()
    {
        foreach ($this->addresses as $key => $address) {
            if (array_get($address, 'primary')) {
                $this->primary = $key;
                break;
            }
        }
    }

    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        $this->addresses[$i] = $this->addrTemplate;
    }

    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->service = resolve(UserAddressesService::class);
    }

    public function remove($i)
    {
        $addressArray = $this->addresses[$i];
        if (isset($addressArray['id'])) {
            $this->service->deleteAddress($addressArray['id']);
        }
        unset($this->addresses[$i]);
        $this->submitDisabled = false;
    }

    /**
     * @return Application|Factory|View|void
     */
    public function render()
    {
        if ($this->authFailed()) {
            return '<div></div>';
        }
        return view('cms-users::site.livewire.cabinet.edit-addresses');
    }

    protected function authFailed(): bool
    {
        if (Auth::check()) {
            return false;
        }

        $this->redirectRoute('home');
        return true;
    }

    /**
     * @throws Throwable
     */
    public function save(CheckForSpam $checkForSpam)
    {
        if (!$checkForSpam->checkInComponent($this)) {
            return;
        }

        if ($this->authFailed()) {
            return;
        }

        $this->resetErrorBag();

        $this->validate(...$this->rules());

        foreach ($this->addresses as $key => $address) {

           $this->primaryAddress($address, $key);

           $obj = $this->service->createOrUpdate(UserAddressesDto::dataRequest($address), $address['id'] ?? null);

           if ($this->primary == $key) {
               UserAddress::where('id', '!=', $obj->id)->update(['primary' => false]);
           }
        }

        $this->submitDisabled = true;

        // Update fields state.
        $this->forgetComputed('addresses');

        $this->addresses = Auth::user()
            ->addresses()
            ->orderBy('id')
            ->get()
            ->toArray();

        $this->primary();

        $response = JsResponse::make()
            ->success(true)
            ->notification(__('cms-core::site.Data saved'));

        $response->emit($this);
    }

    public function primaryAddress(&$address, $key)
    {
        if ($this->primary == $key) {
            $address['primary'] = true;
        } else {
            $address['primary'] = false;
        }
    }

    public function getLocalitiesProperty(): Collection
    {
        return Locality::with('city')->sorting()->get();
    }

    /**
     * @param $field
     */
    public function updated($field)
    {
        $this->submitDisabled = false;
    }

    protected function rules(): array
    {
        return [
            [
                'addresses.*.locality_id'   => 'required|int|exists:localities,id',
                'addresses.*.street' => 'required|string|max:100',
                'addresses.*.house'   => 'required|string|max:20',
                'addresses.*.room'   => 'nullable|int|min:0',
            ],
            [],
            [
                'addresses.*.locality_id'   => __('cms-users::site.Населенный пункт'),
                'addresses.*.street' => __('cms-users::site.Улица'),
                'addresses.*.house'   => __('cms-users::site.Дом'),
                'addresses.*.room'   => __('cms-users::site.Квартира'),
            ]
        ];
    }
}
