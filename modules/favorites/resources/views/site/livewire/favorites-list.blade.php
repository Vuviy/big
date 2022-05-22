@php
    /**
     * @var $result \Illuminate\Pagination\LengthAwarePaginator|\WezomCms\Catalog\Models\Product[]
     * @var $cabinetPage bool
     * @var $selectAllChecked bool
     */
@endphp
@auth()
    <div>
        <div>
            @if($result->isNotEmpty())
                <div class="_mb-df">
                    <div class="_grid _grid--auto _spacer _spacer--df">
                        <div class="_cell">
                            <div class="checkbox checkbox--default" wire:click="selectAll">
                                <input class="checkbox__control"
                                       type="checkbox"
                                       @if($selectAllChecked)
                                       checked
                                        @endif>
                                <label class="checkbox__label" for="notify">
                                <span class="checkbox__checkmark">
                                    @svg('common', 'checkmark', [12,12])
                                </span>
                                    <span class="checkbox__text _fz-xs _color-pantone-gray _fw-medium">@lang('cms-favorites::site.Выбрать все')</span>
                                </label>
                            </div>
                        </div>
                        <div class="_cell">
                            @if(!empty($selected))
                                <button class="_flex _items-center _color-black" wire:click="delete">
                                    <span class="_fz-xs _fw-medium _mr-xs">@lang('cms-favorites::site.Удалить выбранное')</span>
                                    @svg('common', 'cross', 12)
                                </button>
                            @endif
                        </div>
                    </div>
                    {{--<div>
                        <div wire:ignore>
                            <select wire:model="sort" class="js-dmi js-select">
                                @foreach(\WezomCms\Favorites\Enums\SortVariant::asSelectArray() as $key => $name)
                                    <option value="{{ $key }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>--}}
                </div>
                <div>
                    <div class="_grid _spacer _spacer--df _grid--1 _sm:grid--2 _md:grid--3">
                        @foreach($result as $product)
                            <div class="_cell">
                                @include('cms-catalog::site.partials.cards.product-card', ['item' => $product, 'isFavoritesPage' => true])
                            </div>
                        @endforeach
                    </div>
                </div>
                @if($hasMore)
                    <div class="_flex _mt-df _justify-center _items-center">
                        <button type="button" class="button button--theme-transparent-bordered _px-sm _control-height-md _b-r-sm"
                                wire:loading.attr="disabled"
                                wire:loading.class="is-loading"
                                wire:click="loadMore">
                            <span class="_fz-xs">@lang('cms-favorites::site.Загрузить еще')</span>
                        </button>
                    </div>
                @endif
            @else
                <div class="_flex _flex-column _items-center">
                    <img class="_mt-md" src="{{ asset('images/cabinet/wishlist-empty.svg') }}" alt="wishlist empty image">
                    <div class="_md:my-lg _py-sm">
                        <div class="text _fz-xxs _color-black _uppercase _fw-bold _text-center _mb-xs">@lang('cms-favorites::site.Ваш список избранных товаров пустой!')</div>
                        <div class="text _fz-xxs _color-black _uppercase _fw-bold _text-center">@lang('cms-favorites::site.Но не переживайте - на самом деле это очень просто исправить')</div>
                    </div>
                    <a class="button button--theme-black _control-height-md _b-r-sm _px-md" href="{{ route('home') }}">@lang('cms-favorites::site.Перейти на главную')</a>
                    {{--@emptyResult(__('cms-favorites::site.Ваш список избранных товаров пустой!'))--}}
                </div>
            @endif
        </div>
    </div>
@else
    <div class="section _pb-lg">
        <div class="container">
            <h1 class="_fz-xxl _fw-bold _mb-sm _md:mb-df _mt-none">{{ SEO::getH1() }}</h1>
            <div>
                <div>
                    @if($result->isNotEmpty())
                        <div class="_mb-df">
                            <div class="_grid _grid--auto _spacer _spacer--df">
                                <div class="_cell">
                                    <div class="checkbox checkbox--default" wire:click="selectAll">
                                        <input class="checkbox__control"
                                               type="checkbox"
                                               @if($selectAllChecked)
                                               checked
                                                @endif>
                                        <label class="checkbox__label" for="notify">
                                <span class="checkbox__checkmark">
                                    @svg('common', 'checkmark', [12,12])
                                </span>
                                            <span class="checkbox__text _fz-xs _color-pantone-gray _fw-medium">@lang('cms-favorites::site.Выбрать все')</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="_cell">
                                    @if(!empty($selected))
                                        <button class="_flex _items-center _color-black" wire:click="delete">
                                            <span class="_fz-xs _fw-medium _mr-xs">@lang('cms-favorites::site.Удалить выбранное')</span>
                                            @svg('common', 'cross', 12)
                                        </button>
                                    @endif
                                </div>
                            </div>
                            {{--<div>
                                <div wire:ignore>
                                    <select wire:model="sort" class="js-dmi js-select">
                                        @foreach(\WezomCms\Favorites\Enums\SortVariant::asSelectArray() as $key => $name)
                                            <option value="{{ $key }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>--}}
                        </div>
                        <div>
                            <div class="_grid _spacer _spacer--df _grid--1 _sm:grid--2 _md:grid--3 _df:grid--4 _lg:grid--5">
                                @foreach($result as $product)
                                    <div class="_cell">
                                        @include('cms-catalog::site.partials.cards.product-card', ['item' => $product, 'isFavoritesPage' => true])
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @if($hasMore)
                            <div class="_flex _mt-df _justify-center _items-center">
                                <button type="button" class="button button--theme-transparent-bordered _px-sm _control-height-md _b-r-sm"
                                        wire:loading.attr="disabled"
                                        wire:loading.class="is-loading"
                                        wire:click="loadMore">
                                    <span class="_fz-xs">@lang('cms-favorites::site.Загрузить еще')</span>
                                </button>
                            </div>
                        @endif
                    @else
                        <div class="_flex _flex-column _items-center">
                            <img class="_mt-md" src="{{ asset('images/cabinet/wishlist-empty.svg') }}" alt="wishlist empty image">
                            <div class="_md:my-lg _py-sm">
                                <div class="text _fz-xxs _color-black _uppercase _fw-bold _text-center _mb-xs">@lang('cms-favorites::site.Ваш список избранных товаров пустой!')</div>
                                <div class="text _fz-xxs _color-black _uppercase _fw-bold _text-center">@lang('cms-favorites::site.Но не переживайте - на самом деле это очень просто исправить')</div>
                            </div>
                            <a class="button button--theme-black _control-height-md _b-r-sm _px-md" href="{{ route('home') }}">@lang('cms-favorites::site.Перейти на главную')</a>
                            {{--@emptyResult(__('cms-favorites::site.Ваш список избранных товаров пустой!'))--}}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endauth
