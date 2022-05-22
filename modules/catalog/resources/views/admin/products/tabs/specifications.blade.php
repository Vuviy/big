<div id="specifications-tab" data-product-id="{{ $obj->id }}">
    @widget('catalog:product-specifications-tab', ['product' => $obj, 'categoryId' => old('category_id', $obj->category_id)])
</div>
