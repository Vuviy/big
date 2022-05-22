@php
    /**
     * @var $obj WezomCms\Localities\Models\Locality
     */
@endphp
<div class="row">
    <div class="col-lg-7">
        <div class="card mb-3">
            <div class="card-body">
                @langTabs
                <div class="form-group">
                    {!! Form::label($locale.'[name]', __('cms-localities::admin.Name')) !!}
                    {!! Form::text($locale.'[name]', old($locale.'.name', $obj->translateOrNew($locale)->name)) !!}
                </div>
                @endLangTabs
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="py-2"><strong>@lang('cms-core::admin.layout.Main data')</strong></h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('published', __('cms-core::admin.layout.Published')) !!}
                            {!! Form::status('published') !!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('city_id', __('cms-localities::admin.City')) !!}
                    {!! Form::select('city_id', $cities) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('delivery_cost', __('cms-localities::admin.Delivery cost')) !!}
                    <div class="input-group">
                        {!! Form::number('delivery_cost', null, ['min' => 0]) !!}
                        <div class="input-group-append"><span
                                    class="input-group-text">{{ money()->adminCurrencySymbol() }}</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
