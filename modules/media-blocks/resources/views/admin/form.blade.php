<div class="row">
    <div class="col-lg-7">
        <div class="card mb-3">
            <div class="card-body">
                @langTabs
                <div class="form-group">
                    {!! Form::label($locale . '[name]', __('cms-media-blocks::admin.Name')) !!}
                    {!! Form::text($locale . '[name]', old($locale . '.name', $obj->translateOrNew($locale)->name)) !!}
                </div>
                <div class="form-group">
                    {!! Form::label($locale . '[description]', __('cms-media-blocks::admin.Description')) !!}
                    {!! Form::textarea($locale . '[description]', old($locale . '.description', $obj->translateOrNew($locale)->description), ['rows' => 3]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label($locale . '[url]', __('cms-media-blocks::admin.Link')) !!}
                    {!! Form::text($locale . '[url]', old($locale . '.url', $obj->translateOrNew($locale)->url), ['placeholder' => 'http://example.com']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label($locale . '[image]', __('cms-media-blocks::admin.Image')) !!}
                    {!! Form::imageUploader($locale . '[image]', $obj, route($routeName . '.delete-image', [$obj->id, 'image', $locale])) !!}
                </div>
                <div class="form-group">
                    {!! Form::label($locale . '[video]', __('cms-core::admin.video.Video')) !!}
                    {!! Form::videoUploader($locale . '[video]', $obj, route($routeName . '.delete-file', [$obj->id, 'video', $locale]), ['accept' => '.mp4']) !!}
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
                            {!! Form::label('type', __('cms-media-blocks::admin.Location')) !!}
                            {!! Form::select('type', $groups, old('type', $obj->type ?: request()->get('type')), ['class' => 'js-menu-group-selector']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('published', __('cms-media-blocks::admin.Published')) !!}
                            {!! Form::status('published', null, null, null, false) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('open_in_new_tab', __('cms-media-blocks::admin.Open link in new tab')) !!}
                            {!! Form::status('open_in_new_tab', null, null, null, false) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
