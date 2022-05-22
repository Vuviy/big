@php
    /**
     * @var $name string
     * @var $value string[]
     * @var $label string
     * @var $attributes array
     */

    $attributes = array_merge([
        'type' => 'text',
        'name' => $name,
        'autocomplete' => 'off',
        'class' => array_merge(['form-control'], (array)array_get($attributes, 'class', [])),
    ], $attributes);
@endphp
<div class="multiple-inputs js-setting-multiple-input-wrapper">
    <div>
        <label class="control-label">{{ $label }}</label>
        <button type="button" class="btn btn-sm btn-secondary float-right js-add-new-row"><i class="fa fa-plus"></i>&nbsp;@lang('cms-core::admin.layout.Add')
        </button>
    </div>
    <div class="js-multiple-input-list">
        @foreach((array)$value as $itemValue)
            <div class="drag-element js-multiple-input-item mb-1">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text drag-cursor"><i class="fa fa-arrows"></i></span>
                    </div>
                    <input {!! Html::attributes(array_merge($attributes, ['value' => old($name, $itemValue), 'id' => uniqid($name)])) !!}>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-danger js-remove-row" data-toggle="confirmation"
                        ><i class="fa fa-remove"></i>&nbsp;@lang('cms-core::admin.layout.Delete')</button>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="js-empty text-info"
             style="display: {{ count((array)$value) === 0 ? 'block' : 'none' }}">@lang('cms-core::admin.layout.The list is empty')</div>
    </div>
    <div hidden class="js-multiple-input-template">
        <div class="drag-element js-multiple-input-item mb-1">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text drag-cursor"><i class="fa fa-arrows"></i></span>
                </div>
                <input type="text" data-name="{{ $name }}" value="" class="form-control js-input">
                <div class="input-group-append">
                    <button type="button" class="btn btn-danger js-remove-row" data-toggle="confirmation"
                    ><i class="fa fa-remove"></i>&nbsp;@lang('cms-core::admin.layout.Delete')</button>
                </div>
            </div>
        </div>
    </div>
</div>
