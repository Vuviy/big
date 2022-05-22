@php
    $tabs = [
        __('cms-catalog::admin.products.Main data') => $viewPath . '.tabs.main-data',
        __('cms-catalog::admin.specifications.Specifications') => $viewPath . '.tabs.specifications',
        __('cms-catalog::admin.products.Relations') => $viewPath . '.tabs.relations',
        __('cms-catalog::admin.products.SEO') => $viewPath . '.tabs.seo',
    ];

    if (\WezomCms\Core\Foundation\Helpers::providerLoaded(\WezomCms\PromoCodes\PromoCodesServiceProvider::class)) {
        $tabs[__('cms-catalog::admin.Promo codes')] = $viewPath.'.tabs.promo-codes';
    }
@endphp
<div class="row">
    <div class="col-lg-7">
        <div class="card mb-3">
            <div class="card-body">
                @tabs($tabs)
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('published', __('cms-core::admin.layout.Published')) !!}
                            {!! Form::status('published') !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('available', __('cms-catalog::admin.products.Are available')) !!}
                            {!! Form::status('available') !!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('vendor_code', __('cms-catalog::admin.products.Vendor code')) !!}
                    {!! Form::text('vendor_code') !!}
                </div>
                <div class="form-group">
                    {!! Form::label('category_id', __('cms-catalog::admin.products.Category')) !!}
                    <select name="category_id" id="category_id" class="form-control js-select2">
                        <option value="">@lang('cms-core::admin.layout.Not set')</option>
                        @foreach($categoriesTree as $key => $category)
                            <option value="{{ $key }}" {{ $key == old('category_id', $obj->category_id ?: request()->get('category_id')) ? 'selected': null }}
                                    {{ $category['disabled'] ?? false ? 'disabled' : null }}>{!! $category['name'] !!}</option>
                        @endforeach
                    </select>
                </div>
                @widget('catalog:brand-with-model', ['brand' => $obj->brand, 'model' => $obj->model])
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('novelty', __('cms-catalog::admin.products.Novelty')) !!}
                            {!! Form::status('novelty', null, false)  !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('popular', __('cms-catalog::admin.products.Popular')) !!}
                            {!! Form::status('popular', null, false) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('sale', __('cms-catalog::admin.products.Sale')) !!}
                            {!! Form::status('sale', null, false, null, null, ['class' => 'js-product-sale-toggle']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 js-cost-wrapper">
                        <div class="form-group">
                            {!! Form::label('cost', __('cms-catalog::admin.products.Cost')) !!}
                            <div class="input-group">
                                {!! Form::number('cost', str_replace(',', '.', old('cost', $obj->cost)), ['min' => 0, 'step' => '1', 'class' => 'js-product-cost']) !!}
                                <div class="input-group-append"><span
                                            class="input-group-text">{{ money()->adminCurrencySymbol() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 js-old-cost-wrapper">
                        <div class="form-group">
                            {!! Form::label('old_cost', __('cms-catalog::admin.products.Old cost')) !!}
                            <div class="input-group">
                                {!! Form::number('old_cost', str_replace(',', '.', old('old_cost', $obj->old_cost)), ['min' => 0, 'step' => '1', 'class' => 'js-product-old-cost']) !!}
                                    <div class="input-group-append"><span
                                                class="input-group-text">{{ money()->adminCurrencySymbol() }}</span>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row js-percentage-wrapper">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('discount_percentage', __('cms-catalog::admin.products.Discount percentage')) !!}
                            <div class="input-group">
                                {!! Form::text('discount_percentage', null, ['class' => 'js-product-percentage']) !!}
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary js-product-discount" type="button"
                                            title="@lang('cms-catalog::admin.products.Calculate discount price')"><i
                                                class="fa fa-calculator"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('expires_at', __('cms-catalog::admin.products.Expires at')) !!}
                            {!! Form::text('expires_at', old('expires_at', $obj->expires_at ? $obj->expires_at->format('d.m.Y') : null), ['class' => 'js-datepicker', 'placeholder' => __('cms-catalog::admin.products.Expires at')]) !!}
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('PRODUCT_ACCESSORIES[]', __('cms-catalog::admin.products.Accessories')) !!}
                    @include('cms-catalog::admin.products.select', [
                        'products' => $obj->productAccessories,
                        'name' => 'PRODUCT_ACCESSORIES[]',
                        'url' => route('admin.products.search'),
                        'multiple' => true,
                        ['exclude' => $obj->id]])
                </div>

                @foreach(event('catalog:product:form', ['product' => $obj]) as $eventData)
                    {!! $eventData !!}
                @endforeach

                <div class="form-group">
                    {!! Form::multipleInputs('videos[]', old('videos', $obj->videos), __('cms-catalog::admin.products.Videos')) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        @if($obj->exists)
            {!! Form::imageMultiUploader(\WezomCms\Catalog\Models\ProductImage::class, $obj->id) !!}
        @endif
    </div>
</div>
