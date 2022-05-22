@php
    /**
     * @var $products \Illuminate\Pagination\LengthAwarePaginator|\WezomCms\Catalog\Models\Product[]
     * @var $countMore int
     */
@endphp

<div class="_grid _grid--1 _xs:grid--2 _md:grid--3 _df:grid--4 _spacer _spacer--sm">
    @foreach($products as $product)
        <div class="_cell">
            @include('cms-catalog::site.partials.cards.product-card', ['item' => $product])
        </div>
    @endforeach
</div>
