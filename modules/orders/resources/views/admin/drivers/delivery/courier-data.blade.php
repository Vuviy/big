@php
    /**
     * @var $storage \WezomCms\Orders\Models\OrderDeliveryInformation
     */
@endphp
<dl>
    <dt>@lang('cms-orders::admin.orders.Delivery cost')</dt>
    <dd>@money($storage->delivery_cost, true)</dd>
</dl>
<dl>
    <dt>@lang('cms-orders::admin.orders.Locality')</dt>
    <dd>{{ $locality ? ($locality->city->name . ', ' . $locality->name) : __('cms-core::admin.layout.Not set') }}</dd>
</dl>
<div class="row">
    <div class="col-md-6">
        <dl>
            <dt>@lang('cms-orders::admin.courier.Street')</dt>
            <dd>{{ $storage->street ?? __('cms-core::admin.layout.Not set') }}</dd>
        </dl>
    </div>
    <div class="col-md-4">
        <dl>
            <dt>@lang('cms-orders::admin.courier.House')</dt>
            <dd>{{ $storage->house ?? __('cms-core::admin.layout.Not set') }}</dd>
        </dl>
    </div>
    <div class="col-md-2">
        <dl>
            <dt>@lang('cms-orders::admin.courier.Room')</dt>
            <dd>{{ $storage->room ?? __('cms-core::admin.layout.Not set') }}</dd>
        </dl>
    </div>
</div>
