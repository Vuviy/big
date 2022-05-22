@php
/**
 * @var $categoryId int
 * @var $selectedPrimarySpecValues \Illuminate\Support\Collection
 * @var $specifications \Illuminate\Support\Collection|\WezomCms\Catalog\Models\Specifications\Specification[]
 * @var $selectedSpecifications array
 */
@endphp
<div class="form-group">
    {!! Form::label('primarySpecValues[]', __('cms-catalog::admin.products.Primary spec values')) !!}
    <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top"
       title="@lang('cms-catalog::admin.products.Features that will be available for selection when added to the cart')"></i>
    <select name="primarySpecValues[]"
            id="primarySpecValues"
            class="js-ajax-select2"
            data-url="{{ route('admin.specifications.search-grouped-values', ['category_id' => $categoryId]) }}"
            multiple>
        @foreach($selectedPrimarySpecValues as $specValue)
            <option value="{{ $specValue->id }}" selected>{{ $specValue->name }}</option>
        @endforeach
    </select>
</div>

<div class="row">
    @foreach($specifications as $spec)
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('SPEC_VALUES[' . $spec->id . '][]', $spec->name) !!}
                {!! Form::select(
                    'SPEC_VALUES[' . $spec->id . '][]',
                    array_get($selectedSpecifications, $spec->id, []),
                    old('SPEC_VALUES.' . $spec->id . '.*', array_keys(array_get($selectedSpecifications, $spec->id, []))),
                    [
                        'class' => 'js-ajax-select2',
                        'data-url' => route('admin.specifications.search-values', [$spec->id, 'multiple' => $spec->multiple]),
                        'data-minimum-input-length' => 0,
                        'multiple' => $spec->multiple,
                    ]
                )  !!}
            </div>
        </div>
    @endforeach
</div>
