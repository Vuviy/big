<div class="row">
    <div class="col-lg-7">
        <div class="card mb-3">
            <div class="card-body">
                @langTabs
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label($locale . '[name]', __('cms-our-team::admin.Name')) !!}
                            {!! Form::text($locale . '[name]', old($locale . '.name', $obj->translateOrNew($locale)->name)) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label($locale . '[position]', __('cms-our-team::admin.Position')) !!}
                            {!! Form::text($locale . '[position]', old($locale . '.position', $obj->translateOrNew($locale)->position)) !!}
                        </div>
                    </div>
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
                    {!! Form::label('image', __('cms-our-team::admin.Image')) !!}
                    {!! Form::imageUploader('image', $obj, route($routeName . '.delete-image', $obj->id)) !!}
                </div>
            </div>
        </div>
    </div>
</div>
