@php
    $inputId = 'live-search';
@endphp

<form wire:submit.prevent="send" class="search">
    <div class="search__header">
        <label class="search__control">
            <input type="search"
                   class="search__input"
                   wire:model.debounce.50ms="search"
                   autocomplete="off"
                   name="search"
                   placeholder="@lang('cms-search::site.Пошук по сайту')"
                   x-ref="searchInput"
                   @input="onSearchInput($event)"
            >
            <span class="search__overlay-panel">
                <button type="button" class="search__button search__button--search">
                    <span class="search__icon search__icon--search">
                        @svg('common', 'loupe', [18, 18])
                    </span>
                </button>
                <button type="button" class="search__button search__button--clear"
                        :hidden="!hasSearchFieldValue"
                        @click="onSearchInputClear($event)"
                >
                    <span class="search__icon search__icon--clear">
                        @svg('common', 'cross', [15, 15])
                    </span>
                </button>
            </span>
        </label>
        <a href="{{ route('search', ['search' => $search]) }}" class="search__submit button button--theme-yellow _control-padding-md">@lang('cms-search::site.Поиск')</a>
    </div>
    <div class="search__results is-active"
    >
        <div class="_grid _grid--1 _spacer _spacer--xs">
            @error('search')
                <div class="_cell">
                    <div class="_py-sm _px-md">
                        <label id="{{ $inputId }}-error" for="{{ $inputId }}" class="has-error text _fz-xs">
                            {{ $message }}
                        </label>
                    </div>
                </div>
            @enderror
            @if($productCount)
                <div class="_cell" x-ref="searchResult">
                    <div>
                        @foreach($products as $product)
                            <a href="{{ $product->getFrontUrl() }}" class="search-result">
                                <span class="search-result__img">
                                    <img src="{{ $product->getImageUrl('small') }}" alt="{{ $product->name }}">
                                </span>
                                <span class="search-result__text">
                                    {{ $product->name }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                    <div class="search__footer">
                        <div class="_flex _justify-end">
                            <a href="{{ route('search', ['search' => $search]) }}" class="link link--all-results link--theme-gray link--no-decoration">
                                <span class="link__text text _fz-sm">
                                    @lang('cms-search::site.Показать все результаты') ({{ $productCount }})
                                </span>
                                <span class="link__icon">
                                    @svg('common', 'arrow-right', [11, 11])
                                </span>
                            </a>
                        </div>
                    </div>
                @elseif(strlen($search) > 3)
                    <div class="_cell">
                        <div class="_py-sm _px-md">@lang('cms-catalog::site.К сожалению, по вашему запросу ничего не найдено')</div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</form>
