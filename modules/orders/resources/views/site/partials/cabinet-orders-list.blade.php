@php
    /**
     * @var $result \Illuminate\Database\Eloquent\Collection|\WezomCms\Orders\Models\Order[]|\Illuminate\Pagination\LengthAwarePaginator
     */
@endphp

@foreach($result as $item)
    <div class="orders-item">
        <div class="orders-item__head"
             @click.stop="open('{{ $item->id }}')">
            <div class="orders-item__status-label" style="background-color: {{ $item->status->color }};"></div>
            <div class="orders-item__head-grid">
                <div>
                    <div class="orders-item__date _color-faint-strong _fz-xxxs">
                        № {{ $item->id }} @lang('cms-orders::site.history.от') {{ $item->created_at->format('d.m.y') }}
                        <span>{{ $item->created_at->format('H:i') }}</span>
                    </div>
                    <div class="orders-item__status _mt-xs _fz-xs _color-base-strong">
                        {{ $item->status->name }}
                    </div>
                </div>
                <div class="orders-item__toggle-show" x-show.transition.300ms="!isOpened('{{ $item->id }}')">
                    <div class="orders-item__price-title _fz-xxxs _color-faint-strong">@lang('cms-orders::site.history.Сумма заказа')</div>
                    <div class="orders-item__price _mt-xs _fz-xs _color-base-strong">@money($item->whole_purchase_price, true)</div>
                </div>
                <div x-show.transition.300ms="!isOpened('{{ $item->id }}')">
                    <div class="orders-item__gallery orders-item__toggle-show"
                         x-data="{isMobile:window.outerWidth < 768}"
                         @resize.window="window.outerWidth < 768 ? isMobile = true : isMobile = false">
                        @foreach($item->items->slice(0, 6) as $orderItem)
                            <img class="orders-item__gallery-item"
                                 src="{{ $orderItem->product->getImageUrl('small') }}"
                                 alt="{{ $orderItem->product->name }}"
                                 @if($loop->iteration > 4) x-show="!isMobile" @endif
                            >
                        @endforeach
                        @php
                            $desktopCount = ($item->items->count() <= 6) ? null : ('+' . ($item->items->count() - 6));
                            $mobileCount = ($item->items->count() <= 4) ? null : ('+' . ($item->items->count() - 4));
                            $isShownMobile = $mobileCount != null;
                            $isShownDesktop = $desktopCount != null;
                        @endphp
                        <div class="orders-item__gallery-item orders-item__gallery-count _fz-xs _color-base-strong"
                             x-show="isMobile ? '{{ $isShownMobile }}' : '{{ $isShownDesktop }}'"
                             x-text="isMobile ? '{{ $mobileCount }}' : '{{ $desktopCount }}'">{{ $desktopCount }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="orders-item__arrow" :class="{ 'orders-item__arrow--open': isOpened('{{ $item->id }}') }">
                @svg('common', 'arrow-down', 15)
            </div>
        </div>
        <div class="orders-item__body" style="display: none" x-ref="cabinetOrders{{ $item->id }}">
            <div class="orders-item__grid">
                <div>
                    <div class="orders-item__column-title _mb-xs _md:mb-sm _fz-xxxs _color-faint-strong">
                        @lang('cms-orders::site.history.Информация о заказе')
                    </div>
                    <div class="orders-info _fz-xs _color-base-strong">
                        @if(!empty($item->delivery))
                            <div class="orders-info__item">
                                {{ $item->delivery->name }}
                            </div>
                            <div class="orders-info__item">
                                {{ $item->deliveryInformation->getFullDeliveryAddress($item->delivery->driver) }}
                            </div>
                        @endif
                        <div class="orders-info__item">
                            {{ $item->client->full_name }}
                        </div>
                        <div class="orders-info__item">
                            {{ $item->client->phone }}
                        </div>
                        @if(!empty($item->client->email))
                            <div class="orders-info__item">
                                {{ $item->client->email }}
                            </div>
                        @endif
                    </div>
                    @if(!empty($item->client->comment))
                        <div class="orders-item__column-title _mb-xs _mt-sm _md:mb-sm _md:mt-md _fz-xxxs _color-faint-strong">
                            @lang('cms-orders::site.history.Комментарий к заказу')
                        </div>
                        <div class="orders-item__comment _mb-sm _md:mb-none">{{ $item->client->comment }}</div>
                    @endif
                </div>
                <div>
                    <div class="orders-item__column-title _mb-xs _md:mb-sm _mt-sm _md:mt-none _fz-xxxs _color-faint-strong">
                        @lang('cms-orders::site.history.Товары')
                    </div>
                    <div class="orders-products">
                        @foreach($item->items as $orderItem)
                            @php
                                /** @var $orderItem \WezomCms\Orders\Models\OrderItem */
                                $product = $orderItem->product;
                            @endphp
                            <div class="orders-products__item @if(!$loop->last) _mb-sm @endif">
                                <div>
                                    <div class="_flex _items-start">
                                        <div class="orders-products__item-image">
                                            <img src="{{ $product->getImageUrl('small') }}" alt="{{ $product->name }}">
                                        </div>
                                        <div>
                                            <a href="{{ $product->getFrontUrl() }}"
                                               class="orders-products__item-title _mb-xs _fz-xxxs _color-base-strong">
                                                {{ $product->name }}
                                            </a>
                                            <div class="_flex _items-center _mt-xxs _vw:mt-xxs _fz-xs _color-base-strong">
                                                <span class="orders-products__item-price-new">@money($orderItem->product_cost, true)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="orders-products__item-quantity _fz-xs _color-base-strong _text-center">{{ $orderItem->quantity }}</div>
                                <div>
                                    @if($orderItem->product_sale)
                                        <div class="orders-products__item-total-old _fz-xxxs _color-faint-strong">@money($orderItem->whole_product_old_cost, true)</div>
                                        <div class="orders-products__item-total-new _fz-xs _color-base-strong">
                                            @money($orderItem->whole_product_cost, true)
                                        </div>
                                    @else
                                        <div class="orders-products__item-total-new _fz-xs _color-base-strong">
                                            @money($orderItem->whole_product_cost, true)
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="orders-summary _mt-xs _md:mt-sm">
                        @if(!empty($item->payment))
                            <div class="orders-summary__item _fz-xxxs _color-base-strong">
                                <div class="orders-summary__text">@lang('cms-orders::site.history.Способ оплаты')</div>
                                <div class="orders-summary__text">{{ $item->payment->name }}</div>
                            </div>
                        @endif
                            <hr class="separator separator--horizontal separator--theme-faint-weak _my-xs">
                        <div class="orders-summary__item _fz-xxxs _color-base-strong">
                            <div class="orders-summary__text">@lang('cms-orders::site.history.Статус')</div>
                            <div class="orders-summary__text">{{ $item->payed ? __('cms-orders::site.history.Payed') : __('cms-orders::site.history.Not payed') }}</div>
                        </div>
                        <hr class="separator separator--horizontal separator--theme-faint-weak _my-xs">
                        <div class="orders-summary__item _fz-xxxs _color-base-strong">
                            <div class="orders-summary__text">@lang('cms-orders::site.history.Сумма заказа')</div>
                            <div class="orders-summary__text orders-summary__text--black">@money($item->whole_price, true)</div>
                        </div>
                        @if(!empty($item->deliveryInformation) && $item->deliveryInformation->delivery_cost > 0)
                            <div class="orders-summary__item _fz-xxxs _color-base-strong">
                                <div class="orders-summary__text">@lang('cms-orders::site.Стоимость доставки')</div>
                                <div class="orders-summary__text orders-summary__text--black">@money($item->deliveryInformation->delivery_cost, true)</div>
                            </div>
                        @endif
                        <hr class="separator separator--horizontal separator--theme-faint-weak _my-xs">
                        <div class="orders-summary__item _fw-bold _fz-xl _color-base-strong">
                            <div class="orders-summary__text orders-summary__text--black">@lang('cms-orders::site.history.Итого')</div>
                            <div class="orders-summary__text orders-summary__text--black orders-summary__text--big">
                                @money($item->whole_purchase_price, true)
                            </div>
                        </div>
                    </div>
                    @if($item->items->count() === 1)
                        <div class="_mt-sm">
                            <button
                                type="button"
                                class="button button--theme-transparent-bordered _b-r-sm _control-height-md _control-padding-md _control-space-xs _flex-grow"
                                x-data="app.alpine.openModal('product-reviews.form', {{ json_encode(['productId' => $item->items->first()->product->id]) }})"
                                @click="open"
                                @mouseenter="open"
                            >
                                    <span class="button__text">
                                        @lang('cms-product-reviews::site.Оставить отзыв')
                                    </span>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endforeach
