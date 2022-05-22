<?php

namespace WezomCms\Orders\Drivers\Delivery;

use Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Lang;
use WezomCms\Localities\Models\Locality;
use WezomCms\Orders\Contracts\DeliveryDriverInterface;
use WezomCms\Orders\Models\OrderDeliveryInformation;
use WezomCms\Orders\Models\UserAddress;

class Courier implements DeliveryDriverInterface
{
    public const KEY = 'courier';

    /**
     * @return array|string[]
     */
    public function getFormInputs(): array
    {
        return array_fill_keys(['locality_id', 'street', 'house', 'room'], '');
    }

    /**
     * @param  array  $deliveryData
     * @return mixed
     */
    public function renderFormInputs(array $deliveryData)
    {
        $userAddresses = collect();
        if ($user = Auth::user()) {
            /** @var Collection|UserAddress[] $userAddresses */
            $userAddresses = $user->addresses()->latest()->get();

            /** @var UserAddress $address */
            if (!$deliveryData && $address = $userAddresses->first()) {
                $deliveryData = $address->only('locality_id', 'street', 'house', 'room');
            }
        }

        $localities = Locality::with('city')->sorting()->get();
        $selectedLocalityId = array_get($deliveryData, 'locality_id');
        $deliveryCost = null;

        if (!empty($selectedLocalityId)) {
            $selectedLocality = $localities->firstWhere('id', $selectedLocalityId) ?? $localities->first();

            if ($selectedLocality) {
                $deliveryData['locality_id'] = $selectedLocality->id;
                $deliveryCost = $selectedLocality->delivery_cost;
            }
        }

        return view('cms-orders::site.delivery.courier', compact('deliveryData', 'userAddresses', 'localities', 'deliveryCost'));
    }

    /**
     * Get validation rules.
     *
     * @return array
     */
    public function getValidationRules(): array
    {
        return [
            [
                'locality_id' => 'required|int|exists:localities,id',
                'street' => 'required|string|max:100',
                'house' => 'required|string|max:10',
                'room' => 'nullable|int|min:0',
            ],
            [],
            [
                'locality_id' => __('cms-orders::site.checkout.Locality'),
                'street' => __('cms-orders::site.checkout.Street'),
                'house' => __('cms-orders::site.checkout.House'),
                'room' => __('cms-orders::site.checkout.Room'),
            ]
        ];
    }

    /**
     * Fill database storage.
     *
     * @param  OrderDeliveryInformation  $storage
     * @param  array  $data
     */
    public function fillStorage(OrderDeliveryInformation $storage, array $data)
    {
        $storage->fill(array_only($data, ['locality_id', 'street', 'house', 'room', 'delivery_cost']));
    }

    /**
     * @param  OrderDeliveryInformation  $storage
     * @return View
     */
    public function renderAdminFormInputs(OrderDeliveryInformation $storage): View
    {
        $localities = Locality::with('city')->sorting()->get();

        $localities = $localities->mapWithKeys(function ($item, $key) {
            return [$item->id => $item->city->name . ', ' . $item->name];
        });

        $localities->all();

        return view('cms-orders::admin.drivers.delivery.courier', compact('storage', 'localities'));
    }

    /**
     * @param  OrderDeliveryInformation  $storage
     * @return View
     */
    public function renderAdminFormData(OrderDeliveryInformation $storage): View
    {
        return view('cms-orders::admin.drivers.delivery.courier-data', [
            'locality' => $storage->locality,
            'storage' => $storage
        ]);
    }

    /**
     * @param  OrderDeliveryInformation  $storage
     * @return string
     */
    public function presentDeliveryAddress(OrderDeliveryInformation $storage): string
    {
        return implode(
            ', ',
            array_filter([
                $storage->locality->full_name,
                $storage->street,
                Lang::get('cms-orders::' . app('side') . '.house') . ' ' . $storage->house,
                $storage->room ? Lang::get('cms-orders::' . app('side') . '.room') . ' ' . $storage->room : null,
            ])
        );
    }

    public function deliveryCostForCheckout(array $deliveryData): float
    {
        $localityId = array_get($deliveryData, 'locality_id');

        if (!$localityId) {
            return 0;
        }

        $locality = Locality::published()->find($localityId);

        if (!$locality) {
            return 0;
        }

        return $locality->delivery_cost;
    }
}
