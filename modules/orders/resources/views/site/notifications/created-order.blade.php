@php
    /**
     * @var $order \WezomCms\Orders\Models\Order
     * @var $deliveryInformation \WezomCms\Orders\Models\OrderDeliveryInformation|null
     * @var $urlToCabinet string
     */
@endphp
@component('mail::message')

@slot('header_title')
    @lang('cms-orders::site.email.Спасибо за ваш заказ! Ваша заявка принята')
@endslot

@component('mail::partials.table-order-head', [
    'title' => $order->client->name ? __('cms-orders::site.email.:user_name, спасибо за ваш заказ!', [
        'user_name' => $order->client->name
    ]) : __('cms-orders::site.email.Спасибо за ваш заказ!'),
    'text' => __('cms-orders::site.email.Ваша заявка принята. Мы свяжемся с вами в ближайшее время для подтверждения заказа №:order_number.', [
        'order_number' => $order->id
    ]),
    'urlToCabinet' => $urlToCabinet,
])

# {{ __('cms-orders::site.email.Заказ №:number', ['number' => $order->id]) }}

| | |
|-|-:|
| {{ $order->created_at ? $order->created_at->format('d.m.Y H:i') : '----' }} | **@money($order->whole_purchase_price, true).** |
@slot('urlToCabinetText')
    @lang('cms-orders::site.email.Go to your personal cabinet')
@endslot

@slot('orderInfo')
**{{ __('cms-orders::site.email.Заказ №:number', ['number' => $order->id]) }}**

{{ __('cms-orders::site.email.Оформлен :date', ['date' => $order->created_at ? $order->created_at->format('d.m.Y') : '----']) }}

@lang('cms-orders::site.email.Оплата:') {{ ($order->payment ? $order->payment->name : null) ?: __('cms-orders::site.email.Not set') }}
@endslot

@if(!empty($order->delivery))
@slot('orderDelivery')
**{{ $order->delivery->name }}**

@if(isset($deliveryInformation)) {{ $deliveryInformation->getFullDeliveryAddress($order->delivery->driver) }}@endif
@endslot
@endif
@endcomponent

@component('mail::table-order')
| @lang('cms-orders::site.email.Image') | @lang('cms-orders::site.email.Product name') | @lang('cms-orders::site.email.Amount') | @lang('cms-orders::site.email.Total') |
| ------------ | ------------- | ------------- | ------------- |
@foreach($order->items as $item)
| [![{{ $item->name }}]({{ $item->getImageUrl('small', 'image') }})]({{ $item->getFrontUrl() }}) | [**{{ $item->name }}**]({{ $item->getFrontUrl() }}) | <span class="no-wrap">@money($item->purchase_price, true).</span><p>**x&nbsp;{{ str_replace(',', '.', $item->quantity) }}**</p> | <span class="no-wrap">@money($item->whole_purchase_price, true).</span><p>&nbsp;</p> |
@endforeach
@endcomponent

@component('mail::partials.table-order-footer')
@slot('userInfo')

**{{ __('cms-orders::site.email.Покупатель') }}**

{{ $order->client->full_name }}

@if($order->client->email)[{{ $order->client->email }}](mailto:{{ $order->client->email }})@endif

@if($order->client->phone)[{{ $order->client->phone }}](tel:{{ remove_phone_mask($order->client->phone) }})@endif

@endslot

@if($order->client->comment)
@slot('comment')
**{{ __('cms-orders::site.email.Комментарий') }}**

{{ str_replace(["\n", "\r"], ' ', $order->client->comment) }}
@endslot
@endif

<span class="no-wrap">@money($order->whole_purchase_price, true)</span>
@endcomponent

@endcomponent
