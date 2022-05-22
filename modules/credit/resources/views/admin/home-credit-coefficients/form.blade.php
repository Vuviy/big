@php
    /**
     * @var $obj WezomCms\Credit\Models\HalykCoefficient
     */
@endphp
<div class="row">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-body">
                <div class="form-group">
                    {!! Form::label('month', __('cms-credit::admin.Month')) !!}
                    {!! Form::number('month', null, ['min' => 1]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('type', __('cms-credit::admin.Type')) !!}
                    {!! Form::select('type', \WezomCms\Credit\Enums\CreditType::toSelectArray()) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('coefficient', __('cms-credit::admin.Coefficient')) !!}
                    {!! Form::number('coefficient', null, ['min' => 0]) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-body">
                <div class="form-group">
                    {!! Form::label('published', __('cms-core::admin.layout.Published')) !!}
                    {!! Form::status('published') !!}
                </div>
                <div class="form-group">
                    {!! Form::label('availability', __('cms-credit::admin.Availability')) !!}
                    {!! Form::number('availability', null, ['min' => 0]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('max_sum', __('cms-credit::admin.Max sum')) !!}
                    {!! Form::number('max_sum', null, ['min' => 1]) !!}
                </div>
            </div>
        </div>
    </div>
</div>
