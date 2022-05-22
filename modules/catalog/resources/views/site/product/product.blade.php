@extends('cms-ui::layouts.main', ['containerModification' => 'lg'])

@section('content')
    <div class="section section--overflow-hidden">
        <div class="container container--lg">
            <div class="text _fz-xxl _fw-bold _mb-sm">{{ SEO::getH1() }}</div>
            @include('cms-catalog::site.partials.product.tabs')
            @widget('catalog:same-products', ['productId' => $product->id, 'productCategoryId' => $product->category_id, 'sliderType' => 'product-carousel-four-slides'])
        </div>
    </div>
    @widget('benefits:benefits', [], 'cms-benefits::site.widgets.benefits.common')
@endsection
