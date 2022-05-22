@php
    /**
     * @var $searchForm iterable
     */
@endphp
<div>
    @foreach ($searchForm as $group)
        @if(isset($group['visible']) && !$group['visible'])
            @continue
        @endif
        @php
            $allDisabled = true;
            $hasDisabled = false;
            foreach ($group['options'] ?? [] as $option) {
                if ($option['disabled']) {
                    $hasDisabled = true;
                } else {
                    $allDisabled = false;
                }
            }
        @endphp
        @if($group['type'] === \WezomCms\Catalog\Filter\Contracts\FilterFormBuilder::TYPE_HIDDEN)
            <input type="hidden" name="{{ $group['name'] }}" value="{{ $group['value'] }}">
        @else
            @switch($group['type'])
                @case(\WezomCms\Catalog\Filter\Contracts\FilterFormBuilder::TYPE_RADIO)
                @case(\WezomCms\Catalog\Filter\Contracts\FilterFormBuilder::TYPE_CHECKBOX)
                    <div class="accordion accordion--filter-group"
                         x-data="app.alpine.singleAccordion({ namespaceRef: ''})"
                         x-init="open('{{ $group['name'] }}')"
                    >
                        <div class="accordion__header" @click="open('{{ $group['name'] }}')">
                            <div class="text _fz-def _fw-bold _color-black">{{ $group['title'] }}</div>

                            <div class="accordion__trigger">
                                <div class="accordion__trigger-icon icon is-active" :class="{'is-active' : isOpened('{{ $group['name'] }}')}">
                                    @svg('common', 'arrow-down', 10)
                                </div>
                            </div>
                        </div>
                        @php
                            $hasSearch = count($group['options']) >= 7;
                        @endphp
                        <div class="accordion__body" x-ref="{{ $group['name'] }}"
                             @if($hasSearch) x-data="{ str: '' }" @endif
                        >
                            @if($hasSearch)
                                <div
                                    class="form-item form-item--input form-item--theme-base-weak form-item--search-field _control-height-md _control-padding-xs _mb-sm">
                                    <div class="form-item__body">
                                        <input class="form-item__control _fz-xs _color-black js-ignore"
                                               type="text"
                                               placeholder="{{ __('cms-catalog::site.Поиск') }}"
                                               x-model="str"
                                        />
                                        <div class="form-item__icon icon icon--size-sm">
                                            @svg('common', 'loupe', 14)
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="accordion__body-inner scrollbar">
                                <div>
                                    @foreach($group['options'] as $option)
                                        <div class="checkbox checkbox--default @if(!$loop->first) _mt-sm @endif" {!! $option['disabled'] && ! $allDisabled ? 'hidden' : '' !!}
                                            @if($hasSearch) x-show="'{{ mb_strtolower($option['name']) }}'.includes(str.toLowerCase())" @endif
                                        >
                                            <input class="checkbox__control"
                                                   type="{{ $group['type'] === \WezomCms\Catalog\Filter\Contracts\FilterFormBuilder::TYPE_RADIO ? 'radio' : 'checkbox' }}"
                                                   name="{{ $option['input_name'] ?? $group['name'] }}"
                                                   value="{{ $option['value'] }}"
                                                   id="{{$group['name']}}-option-{{ $loop->index }}"
                                                {{ $option['selected'] ? 'checked' : '' }} {{ $option['disabled'] ? 'disabled' : '' }}
                                            >
                                            <label class="checkbox__label" for="{{$group['name']}}-option-{{ $loop->index }}">
                                            <span class="checkbox__checkmark">
                                                @svg('common', 'checkmark', [12,12])
                                            </span>
                                                <span class="checkbox__text _fz-xs _color-pantone-gray">{{ $option['name'] }}</span>
                                            </label>
                                            @if(!$option['disabled'] && !$option['selected'])
                                                <a href="{{ $option['url'] }}"></a>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @break
                @case(\WezomCms\Catalog\Filter\Contracts\FilterFormBuilder::TYPE_CHECKBOX_WITH_NO_CHECKMARK)
                <div class="accordion accordion--filter-group"
                     x-data="app.alpine.singleAccordion({ namespaceRef: ''})"
                     x-init="open('{{ $group['name'] }}')"
                >
                    <div class="accordion__header" @click="open('{{ $group['name'] }}')">
                        <div class="text _fz-def _fw-bold _color-black">{{ $group['title'] }}</div>

                        <div class="accordion__trigger">
                            <div class="accordion__trigger-icon icon is-active" :class="{'is-active' : isOpened('{{ $group['name'] }}')}">
                                @svg('common', 'arrow-down', 10)
                            </div>
                        </div>
                    </div>
                    <div class="accordion__body" x-ref="{{ $group['name'] }}">
                        <div class="accordion__body-inner scrollbar">
                            <div>
                                @foreach($group['options'] as $option)
                                    <div class="checkbox checkbox--with-no-checkmark @if(!$loop->first) _mt-sm @endif" {!! $option['disabled'] && ! $allDisabled ? 'hidden' : '' !!}
                                    >
                                        <input class="checkbox__control"
                                               type="{{ $group['type'] === \WezomCms\Catalog\Filter\Contracts\FilterFormBuilder::TYPE_RADIO ? 'radio' : 'checkbox' }}"
                                               name="{{ $option['input_name'] ?? $group['name'] }}"
                                               value="{{ $option['value'] }}"
                                               id="{{$group['name']}}-option-{{ $loop->index }}"
                                            {{ $option['selected'] ? 'checked' : '' }} {{ $option['disabled'] ? 'disabled' : '' }}
                                        >
                                        <label class="checkbox__label" for="{{$group['name']}}-option-{{ $loop->index }}">
                                        <span class="checkbox__checkmark">
                                        </span>
                                            <span class="checkbox__text _fz-xs _color-pantone-gray">{{ $option['name'] }}</span>
                                        </label>
                                        @if(!$option['disabled'] && !$option['selected'])
                                            <a href="{{ $option['url'] }}"></a>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @break
                @case(\WezomCms\Catalog\Filter\Contracts\FilterFormBuilder::TYPE_NUMBER_RANGE)
                @if($group['from']['min'] && $group['to']['max'])
                    <div class="accordion accordion--filter-group"
                         x-data="app.alpine.singleAccordion({ namespaceRef: ''})"
                         x-init="open('price')"
                    >
                        <div class="accordion__header" @click="open('price')">
                            <div class="text _fz-def _fw-bold _color-black">{{ $group['title'] }}</div>

                            <div class="accordion__trigger">
                                <div class="accordion__trigger-icon icon is-active" :class="{'is-active' : isOpened('price')}">
                                    @svg('common', 'arrow-down', 10)
                                </div>
                            </div>
                        </div>
                        <div class="accordion__body" x-ref="price" style="">
                            <div class="_grid _flex-nowrap">
                                <div class="_cell _cell--auto _flex _items-center _flex-grow _mr-xs">
                                    <div
                                        class="form-item form-item--input form-item--theme-base-weak _control-height-md _control-padding-xs">
                                        <div class="form-item__body">
                                            <input class="form-item__control _fz-xs _color-black _text-center"
                                                   type="number"
                                                   name="{{ $group['from']['name'] }}"
                                                   value="{{ $group['from']['value'] ?? $group['from']['min'] ?? '' }}"
                                                   placeholder="{{ $group['from']['placeholder'] ?? '' }}"
                                                   min="{{ $group['from']['min'] ?? '' }}"
                                            />
                                        </div>
                                    </div>
                                    <div class="separator separator--price separator--theme-gray _flex-noshrink"></div>
                                    <div
                                        class="form-item form-item--input form-item--theme-base-weak _control-height-md _control-padding-xs">
                                        <div class="form-item__body">
                                            <input class="form-item__control _fz-xs _color-black _text-center"
                                                   type="number"
                                                   name="{{ $group['to']['name'] }}"
                                                   value="{{ $group['to']['value'] ?? $group['to']['max'] ?? '' }}"
                                                   placeholder="{{ $group['to']['placeholder'] ?? '' }}"
                                                   max="{{ $group['to']['max'] ?? '' }}"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div class="_cell _cell--auto">
                                    <button
                                        class="button button--theme-yellow _control-height-md _control-padding-xs _b-r-sm">
                            <span class="button__text _fz-sm _color-black _fw-medium">
                                ОК
                            </span>
                                    </button>
                                </div>
                            </div>
                            <label>
                                <input type="hidden"
                                       data-min="{{ $group['from']['min'] ?? 0 }}"
                                       data-max="{{ $group['to']['max'] ?? 0 }}"
                                       data-from="{{ $group['from']['value'] ?? $group['from']['min'] ?? 0 }}"
                                       data-to="{{ $group['to']['value'] ?? $group['to']['max'] ?? 0 }}"/>
                            </label>
                        </div>
                    </div>
                @endif
                @break
                @case(\WezomCms\Catalog\Filter\Contracts\FilterFormBuilder::TYPE_CHECKBOX_WITH_ICON)
                @case(\WezomCms\Catalog\Filter\Contracts\FilterFormBuilder::TYPE_RADIO_WITH_ICON)
                @case(\WezomCms\Catalog\Filter\Contracts\FilterFormBuilder::TYPE_SELECT)
                @case(\WezomCms\Catalog\Filter\Contracts\FilterFormBuilder::TYPE_SELECT_RANGE)
                @case(\WezomCms\Catalog\Filter\Contracts\FilterFormBuilder::TYPE_NUMBER)
                @case(\WezomCms\Catalog\Filter\Contracts\FilterFormBuilder::TYPE_DOUBLE)
                @break
            @endswitch
        @endif
    @endforeach
</div>
