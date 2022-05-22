@php
    /**
     * @var $products \Illuminate\Pagination\LengthAwarePaginator|\WezomCms\Catalog\Models\Product[]
     * @var $filter \WezomCms\Catalog\Filter\Contracts\FilterInterface|null
     */
@endphp

@if($products->isNotEmpty())
    @include('cms-catalog::site.partials.products-list')
@else
    @emptyResult(isset($filter) && $filter->getUrlBuilder()->getParameters() ? __('cms-catalog::site.К сожалению, по Вашим параметрам ничего не найдено') : null)
@endif



