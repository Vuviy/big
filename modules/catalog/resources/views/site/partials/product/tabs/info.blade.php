@php
    /**
     * @var $product \WezomCms\Catalog\Models\Product
     * @var $variations \Illuminate\Support\Collection|\WezomCms\Catalog\Models\Product[]
     * @var $specifications \Illuminate\Support\Collection
     */
@endphp

@include('cms-catalog::site.partials.product.gallery')
@widget('orders:product-delivery-and-payment-text')
