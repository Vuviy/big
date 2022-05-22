<div class="row">
    <div class="col-lg-7">
        <div class="card mb-3">
            <div class="card-body">
                @langTabs
                <div class="form-group">
                    {!! Form::label($locale . '[name]', __('cms-branches::admin.Name')) !!}
                    {!! Form::text($locale . '[name]', old($locale . '.name', $obj->translateOrNew($locale)->name)) !!}
                </div>
                <div class="form-group">
                    {!! Form::label($locale . '[address]', __('cms-branches::admin.Address')) !!}
                    {!! Form::text($locale . '[address]', old($locale . '.address', $obj->translateOrNew($locale)->address)) !!}
                </div>
                <div class="form-group">
                    {!! Form::label($locale . '[schedule]', __('cms-branches::admin.Schedule')) !!}
                    {!! Form::text($locale . '[schedule]', old($locale . '.schedule', $obj->translateOrNew($locale)->schedule)) !!}
                </div>
                @endLangTabs
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header"><h4>@lang('cms-branches::admin.Map')</h4></div>
            <div class="card-body">
                {!! Form::map('map', $obj->map) !!}
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card mb-3">
            <div class="card-body">
                <div class="form-group">
                    {!! Form::label(str_slug('published'), __('cms-core::admin.layout.Published')) !!}
                    {!! Form::status('published') !!}
                </div>
                <div class="form-group">
                    {!! Form::multipleInputs('phones[]', old('phones', $obj->phones), __('cms-branches::admin.Phones')) !!}
                </div>
            </div>
        </div>
    </div>
</div>
