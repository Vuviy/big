@extends('cms-users::site.layouts.cabinet')

@php
    /**
     * @var $result \Illuminate\Database\Eloquent\Collection|\WezomCms\Orders\Models\Order[]|\Illuminate\Pagination\LengthAwarePaginator
     */
@endphp

@section('content')
    <div class="orders">
        @if(!$result->isEmpty())
            <div class="_md:mt-df js-order-history-list"
                 x-data="app.alpine.singleAccordion({ namespaceRef: 'cabinetOrders' })">
                @include('cms-orders::site.partials.cabinet-orders-list')
            </div>

            <div class="_flex _items-center _justify-center">
                @if($result->hasMorePages())
                    @php($countMore = count_more($result))
                    <div
                        data-load-more="{{ json_encode([
                                                    'route' => $result->nextPageUrl(),
                                                    'appendTo' => '.js-order-history-list',
                                                    'countMore' => '.js-order-history-count-more',
                                                ]) }}"
                        class="load-more _flex-noshrink _mt-md _vw:mt-md js-dmi"
                    >
                        <div class="load-more__icon">
                            @svg('common', 'arrow-update', 23)
                        </div>
                        <div class="_color-pantone-gray _fz-xxxs _ml-xs">
                            @lang('cms-orders::site.Показать еще') <span class="js-order-history-count-more">{{ $countMore }}</span> {{ trans_choice('cms-orders::site.заказ|заказа|заказов', $countMore) }}
                        </div>
                    </div>
                @endif
            </div>
        @else
            <div class="_flex _flex-column _items-center">
                <img class="_mt-md" src="{{ asset('images/cabinet/orders-empty.svg') }}" alt="wishlist empty image">
                <div class="_md:my-lg _py-sm">
                    <div class="text _fz-xxs _color-black _uppercase _fw-bold _text-center _mb-xs">@lang('cms-orders::site.Вы еще не заказали у нас товар?')</div>
                    <div class="text _fz-xxs _color-black _uppercase _fw-bold _text-center">@lang('cms-orders::site.Но не переживайте - на самом деле это просто')</div>
                </div>
                <a class="button button--theme-black _control-height-md _b-r-sm _px-md" href="{{ route('home') }}">@lang('cms-orders::site.Перейти на главную')</a>
                {{--@emptyResult(__('cms-favorites::site.Ваш список избранных товаров пустой!'))--}}
            </div>
        @endif

    </div>
@endsection
