@if(!empty(settings('deliveries.advantages.advantages')))
    <div class="accordion accordion--blocks"
         x-data="app.alpine.singleAccordion({ namespaceRef: ''})" x-init="open('delivery')"
    >
        <div class="accordion__header"
             @click="open('delivery')"
        >
            <div class="text _fz-def _fw-bold">
                @lang('cms-catalog::site.Доставка')
            </div>
            <div class="accordion__trigger">
                <div class="accordion__trigger-icon icon"
                     :class="{'is-active' : isOpened('delivery')}"
                >
                    @svg('common', 'arrow-down', [10, 10])
                </div>
            </div>
        </div>
        <div class="accordion__body"
             x-ref="delivery"
             style="display: none"
        >
            <div class="accordion__body-inner">
                <ul class="list list--blocks">
                    @foreach(settings('deliveries.advantages.advantages', []) ?? [] as $advantage)
                        @php
                            $id = uniqid('delivery-tooltip-');
                        @endphp
                        @if(!empty($advantage['text']))
                            <li class="list__item _flex _items-center _mb-xs">
                                <div class="text _fz-xs _color-faint-strong">
                                    {{ $advantage['text'] }}
                                </div>
                                @if(isset($advantage['tooltip']) && $advantage['tooltip'])
                                    <div class="tooltip js-dmi _ml-xs" data-tippy data-template="{{ $id }}">
                                        @svg('common', 'info', 16, 'icon tooltip__icon tooltip__icon--faint-strong')
                                    </div>
                                    <template id="{{ $id }}">
                                        {{ $advantage['tooltip'] }}
                                    </template>
                                @endif
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
{{--@endif--}}
{{--@if(!empty(settings('payments.advantages.advantages')))--}}
    <div class="accordion accordion--blocks"
     x-data="app.alpine.singleAccordion({ namespaceRef: '' })"
         x-init="open('payment')"
>
    <div class="accordion__header"
         @click="open('payment')"
    >
        <div class="text _fz-def _fw-bold">
            @lang('cms-catalog::site.Оплата')
        </div>
        <div class="accordion__trigger">
            <div class="accordion__trigger-icon icon"
                 :class="{'is-active' : isOpened('payment')}"
            >
                @svg('common', 'arrow-down', [10, 10])
            </div>
        </div>
    </div>
    <div class="accordion__body"
         x-ref="payment"
         style="display: none"
    >
        <div class="accordion__body-inner">
            <ul class="list list--blocks">
                @foreach(settings('payments.advantages.advantages', []) ?? [] as $advantage)
                    @php
                        $id = uniqid('payment-tooltip-');
                    @endphp
                    @if(!empty($advantage['text']))
                        <li class="list__item _flex _items-center _mb-xs">
                            <div class="text _fz-xs _color-faint-strong">
                                {{ $advantage['text'] }}
                            </div>
                            @if(isset($advantage['tooltip']) && $advantage['tooltip'])
                                <div class="tooltip js-dmi _ml-xs" data-tippy data-template="{{ $id }}">
                                    @svg('common', 'info', 16, 'icon tooltip__icon tooltip__icon--faint-strong')
                                </div>
                                <template id="{{ $id }}">
                                    {{ $advantage['tooltip'] }}
                                </template>
                            @endif
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif
