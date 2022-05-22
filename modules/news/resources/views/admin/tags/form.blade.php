<div class="row">
    <div class="col-lg-7">
        <div class="card mb-3">
            <div class="card-body">
                @langTabs
                    <div class="form-group">
                        {!! Form::label($locale . '[name]', __('cms-news::admin.Name')) !!}
                        {!! Form::text($locale . '[name]', old($locale . '.name', $obj->translateOrNew($locale)->name), ['class' => ($loop->first ? 'slug-source' : '')]) !!}
                    </div>

                    @include('cms-core::admin.partials.form-meta-inputs', compact('obj', 'locale'))
                @endLangTabs
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="py-2"><strong>@lang('cms-core::admin.layout.Main data')</strong></h5>
            </div>
            <div class="card-body">
                <div class="form-group">
                    {!! Form::label('published', __('cms-core::admin.layout.Published')) !!}
                    {!! Form::status('published') !!}
                </div>
                <div class="form-group">
                    {!! Form::label('slug', __('cms-core::admin.layout.Slug')) !!}
                    {!! Form::slugInput('slug', old('slug', $obj->slug), ['source' => 'input.slug-source']) !!}
                </div>
            </div>
        </div>
    </div>
</div>
