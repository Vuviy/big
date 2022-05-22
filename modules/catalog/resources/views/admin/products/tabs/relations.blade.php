@php
/**
 * @var $obj \WezomCms\Catalog\Models\Product
 */
@endphp
<div class="form-group">
    {!! Form::label('group_key', __('cms-catalog::admin.products.Group key')) !!}
    <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top"
       title="@lang('cms-catalog::admin.products.Specify the key by which the goods will be combined')"></i>
    {!! Form::text('group_key') !!}
</div>

@foreach(event('admin:product-form', $obj) as $event)
    {!! $event !!}
@endforeach
