@php
    /**
     * @var $categories \Illuminate\Database\Eloquent\Collection|\WezomCms\Catalog\Models\Category[]|null
     * @var $products \Illuminate\Database\Eloquent\Collection|\WezomCms\Catalog\Models\Product[]
     * @var $viewModel \Illuminate\Database\Eloquent\Model|null
     * @var $selected \Illuminate\Support\Collection
     * @var $sort \WezomCms\Catalog\Filter\Sort
     * @var $searchForm iterable
     * @var $baseUrl string
     **/
@endphp

@extends('cms-ui::layouts.main')

@section('content')
    @if(isset($viewCategories) && $viewCategories->isNotEmpty())
        <div class="section section--off-b-md">
            <div class="container">
                @include('cms-catalog::site.partials.categories-list')
            </div>
        </div>
    @endif
    <div class="section section--off-b-lg">
        <div class="container">
            <div class="_mb-df">
                <h1 class="text _fz-xxl _fw-bold _color-black">{{ SEO::getH1() }}</h1>
            </div>
            <div
                x-data="app.alpine.catalogFilter()"
                @resize.window.debounce.75="isFilterOpen ? isFilterOpen = false : null"
                class="js-dmi js-catalog"
                data-route="{{ $baseUrl }}"
            >
                <div x-show.transition.opacity.duration.300ms="isFilterOpen"
                     x-cloak
                     style="display: none"
                     class="modal _lg:hide" @click="toggleFilter($event)"
                ></div>
                <div class="_grid _spacer _spacer--sm">
                    <div class="_cell _cell--12 _lg:cell--2 _lg:pr-sm">
                        <div class="js-filter catalog-filter"
                             :class="{ 'is-open': isFilterOpen }"
                             data-route="{{ $baseUrl }}"
                        >
                            <div class="js-selection">
                                @include('cms-catalog::site.partials.selected')
                            </div>
                            <div class="js-filter-dynamic">
                                @include('cms-catalog::site.partials.filter')
                            </div>
                        </div>
                    </div>
                    <div class="_cell _cell--12 _lg:cell--10">
                        <div class="catalog-list" data-load-pending="false">
                            <div class="_grid _grid--1 _md:grid--auto _spacer _spacer--sm _md:flex-row-reverse _justify-between _md:items-center _md:flex-wrap _mb-none">
                                <div class="_cell">
                                    <div class="_grid _spacer _spacer--sm">
                                        <div class="_cell _cell--auto _flex _flex-grow">
                                            <div class="button button--theme-yellow _control-height-md _control-padding-md _control-space-md _lg:hide _flex-grow"
                                                 @click="toggleFilter($event)"
                                            >
                                                <div class="button__icon button__icon--left">
                                                    @svg('common', 'filter', 16)
                                                </div>
                                                <div class="button__text">
                                                    @lang('cms-catalog::site.Фильтры')
                                                </div>
                                            </div>
                                        </div>
                                        <div class="_cell _cell--auto _flex _flex-grow">
                                            @include('cms-catalog::site.partials.sorting')
                                        </div>
                                    </div>
                                </div>
                                <div class="_cell">
                                    <div class="js-catalog-flags _md:mr-auto">
                                        @widget('catalog:catalog-flag-filter', compact('searchForm'))
                                    </div>
                                </div>
                            </div>

                            <div class="js-catalog-goods _mb-df">
                                @include('cms-catalog::site.partials.products')
                            </div>

                            <div class="js-pagination">
                                @include('cms-catalog::site.partials.products-pagination')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @widget('benefits:benefits', [], 'cms-benefits::site.widgets.benefits.common')
@endsection

@section('hideH1', true)
