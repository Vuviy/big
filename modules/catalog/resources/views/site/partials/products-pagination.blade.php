@php
    /**
     * @var $products \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection|\WezomCms\Catalog\Models\Product[]
     */
@endphp

<div>
    {!! $products->links() !!}
</div>
