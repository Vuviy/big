<div class="row">
    <div class="col-lg-7">
        <div class="card mb-3">
            <div class="card-body">
                @langTabs
                <div class="form-group">
                    {!! Form::label($locale . '[name]', __('cms-benefits::admin.Name')) !!}
                    {!! Form::text($locale . '[name]', old($locale . '.name', $obj->translateOrNew($locale)->name)) !!}
                </div>
                <div class="form-group">
                    {!! Form::label($locale . '[description]', __('cms-benefits::admin.Description')) !!}
                    {!! Form::textarea($locale . '[description]', old($locale . '.description', $obj->translateOrNew($locale)->description), ['rows' => 3]) !!}
                </div>
                @endLangTabs
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md">
                        <div class="form-group">
                            {!! Form::label('type', __('cms-benefits::admin.Location')) !!}
                            {!! Form::select('type', $types, old('type', $obj->type ?: request()->get('type')), ['class' => 'js-menu-group-selector']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('published', __('cms-core::admin.layout.Published')) !!}
                            {!! Form::status('published', null, null, null, false) !!}
                        </div>
                    </div>
                    <div class="col-md-9">
                        {!! Form::label('icon', __('cms-benefits::admin.Icon')) !!}
                        <select name="icon" id="icon" class="js-select2" data-template="svg-select">
                            @foreach(getSvgList('features') as $key => $value)
                                <option @if($obj->icon === $key) selected @endif {!! Html::attributes([
                                    'value' => $key,
                                    'data-sprite' => 'features',
                                    'data-icon' => $value]) !!}
                                ></option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
