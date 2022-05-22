<div class="row">
    <div class="col-lg-7">
        <div class="card mb-3">
            <div class="card-body">
                @langTabs
                <div class="form-group">
                    {!! Form::label($locale . '[name]', __('cms-orders::admin.statuses.Name')) !!}
                    {!! Form::text($locale . '[name]', old($locale . '.name', $obj->translateOrNew($locale)->name))  !!}
                </div>
                @endLangTabs
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card mb-3">
            <div class="card-body">
                <div class="form-group">
                    {!! Form::label('color', __('cms-orders::admin.statuses.Color')) !!}
                    {!! Form::text('color', null, ['class' => 'js-color-picker']) !!}
                </div>
            </div>
        </div>
    </div>
</div>

