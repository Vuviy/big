<div class="row">
    <div class="col-lg-7">
        <div class="card mb-3">
            <div class="card-body">
                @langTabs
                <div class="form-group">
                    {!! Form::label($locale . '[name]', __('cms-about::admin.Name')) !!}
                    {!! Form::text($locale . '[name]', old($locale . '.name', $obj->translateOrNew($locale)->name)) !!}
                </div>
                <div class="form-group">
                    {!! Form::label($locale . '[description]', __('cms-about::admin.Description')) !!}
                    {!! Form::textarea($locale . '[description]', old($locale . '.description', $obj->translateOrNew($locale)->description), ['class' => 'js-wysiwyg', 'data-lang' => $locale]) !!}
                </div>
                @endLangTabs
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card mb-3">
            <div class="card-body">
                <div class="form-group">
                    {!! Form::label('published', __('cms-core::admin.layout.Published')) !!}
                    {!! Form::status('published') !!}
                </div>
                <div class="form-group">
                    {!! Form::label('happened_at', __('cms-about::admin.Happened at')) !!}
                    {!! Form::text('happened_at', old('happened_at', $obj->happened_at ? $obj->happened_at->format('d.m.Y') : null), ['class' => 'js-datepicker', 'placeholder' => __('cms-about::admin.Happened at')]) !!}
                </div>
            </div>
        </div>
    </div>
</div>
