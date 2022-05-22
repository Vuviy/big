@extends('cms-orders::site.layouts.checkout', ['containerModification' => 'sm'])

@php
    /**
     * @var $order \WezomCms\Orders\Models\Order
     */
@endphp

@section('content')
    <div class="section section--off-t-md section--off-b-md">
        <div class="container container--sm">
            <div class="text _fz-xxl _fw-bold _color-black _text-center _mb-sm _lg:mb-lg">
                @lang('cms-orders::site.Спасибо, заказ оформлен')
            </div>
            <div class="text _fz-xxs _color-black _text-center _fw-bold _mb-sm">
                @lang('cms-orders::site.Заказ') № {{ $order->id }}
            </div>

            <div class="_grid _grid--4 _md:grid--6 _df:grid--8 _justify-center _spacer _spacer--sm">
                @foreach($order->items as $item)
                    <div class="_cell">
                        <a href="{{ $item->product->getFrontUrl() }}" class="link">
                            <span class="image image--checkout-product _flex">
                                <img src="{{ $item->product->getImageUrl() }}" alt="{{ $item->product->name }}">
                            </span>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="_flex _items-center _justify-between _mb-sm">
                <div class="text _fz-xs _color-base-strong">
                    @lang('cms-orders::site.Дата заказа')
                </div>
                <div class="text _fz-xs _color-base-strong _text-right">
                    {{ localizedDate($order->created_at) }}
                </div>
            </div>

            @if($order->delivery)
                <div class="_flex _items-center _justify-between _mb-sm">
                    <div class="text _fz-xs _color-base-strong">
                        @lang('cms-orders::site.Адрес доставки')
                    </div>
                    <div class="text _fz-xs _color-base-strong _text-right">
                        {{ $order->deliveryInformation->getFullDeliveryAddress($order->delivery->driver) }}
                    </div>
                </div>
            @endif

            @if($payment = $order->payment)
                <div class="_flex _items-center _justify-between _mb-sm">
                    <div class="text _fz-xs _color-base-strong">
                        @lang('cms-orders::site.Способ оплаты')
                    </div>
                    <div class="text _fz-xs _color-base-strong _text-right">
                        {{ $payment->name }}
                    </div>
                </div>
            @endif

            <div class="_flex _items-center _justify-between _mb-sm">
                <div class="text _fz-xs _color-base-strong">
                    @lang('cms-orders::site.Получатель')
                </div>
                <div class="text _fz-xs _color-base-strong _text-right">
                    {{ $order->client->full_name . ', ' . $order->client->phone }}
                </div>
            </div>

            <hr class="separator separator--horizontal separator--offset-md">
            <div class="_flex _items-center _justify-between _mb-sm">
                <div class="text _fz-xs _color-base-strong">
                    @lang('cms-orders::site.Сумма заказа')
                </div>
                <div class="text _fz-xs _color-base-strong _text-right">
                    @money($order->whole_price, true)
                </div>
            </div>
            @if($order->deliveryInformation->delivery_cost > 0)
                <div class="_flex _items-center _justify-between _mb-sm">
                    <div class="text _fz-xs _color-base-strong">
                        @lang('cms-orders::site.Стоимость доставки')
                    </div>
                    <div class="text _fz-xs _color-base-strong _text-right">
                        @money($order->deliveryInformation->delivery_cost, true)
                    </div>
                </div>
            @endif

            <hr class="separator separator--horizontal separator--offset-md">
            <div class="_flex _items-center _justify-between _mb-sm">
                <div class="text _fz-xl _fw-bold _color-base-strong">
                    @lang('cms-orders::site.Итого к оплате')
                </div>
                <div class="text _fz-xl _fw-bold _color-black _text-right">
                    @money($order->whole_purchase_price, true)
                </div>
            </div>
            <hr class="separator separator--horizontal separator--offset-md _lg:mb-lg">

            <div class="_grid _justify-center _spacer _spacer--md">
                <div class="_cell _cell--12 _lg:cell--8">
                    <div class="_flex _justify-center">
                        @auth()
                            <a href="{{ route('cabinet.orders') }}"
                               class="button button--theme-yellow _control-height-md _control-padding-md _b-r-sm"
                            >
                                <span class="button__text">@lang('cms-orders::site.Перейти в кабинет')</span>
                            </a>
                        @else
                            <a href="{{ route('home') }}"
                               class="button button--theme-yellow _control-height-md _control-padding-md _b-r-sm"
                            >
                                <span class="button__text">@lang('cms-orders::site.Вернуться на главную')</span>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
