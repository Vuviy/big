@php
    /**
     * @var $storage \WezomCms\Orders\Models\OrderDeliveryInformation
     */
@endphp

<div class="form-group">
    {!! Form::label('deliveryInformation[delivery_cost]', __('cms-orders::admin.orders.Delivery cost')) !!}
    <div class="input-group">
        {!! Form::number('deliveryInformation[delivery_cost]', old('deliveryInformation.delivery_cost', $storage->delivery_cost), ['min' => 0]) !!}
        <div class="input-group-append"><span class="input-group-text">{{ money()->adminCurrencySymbol() }}</span></div>
    </div>
</div>
<div class="form-group">
    {!! Form::label('deliveryInformation[locality_id]', __('cms-orders::admin.orders.Locality')) !!}
    {!! Form::select('deliveryInformation[locality_id]', $localities, old('deliveryInformation.locality_id', $storage->locality_id), ['placeholder' => __('cms-core::admin.layout.Not set')]) !!}
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('deliveryInformation[street]', __('cms-orders::admin.courier.Street')) !!}
            {!! Form::text('deliveryInformation[street]', old('deliveryInformation.street', $storage->street)) !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label('deliveryInformation[house]', __('cms-orders::admin.courier.House')) !!}
            {!! Form::text('deliveryInformation[house]', old('deliveryInformation.house', $storage->house)) !!}
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::label('deliveryInformation[room]', __('cms-orders::admin.courier.Room')) !!}
            {!! Form::text('deliveryInformation[room]', old('deliveryInformation.room', $storage->room)) !!}
        </div>
    </div>
</div>
