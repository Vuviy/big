@php
    /**
     * @var $obj WezomCms\Localities\Models\City
     */
@endphp
<div class="row">
    <div class="col-lg-7">
        <div class="card mb-3">
            <div class="card-body">
                @langTabs
                    <div class="form-group">
                        {!! Form::label($locale.'[name]', __('cms-localities::admin.Name')) !!}
                        {!! Form::text($locale.'[name]', old($locale.'.name', $obj->translateOrNew($locale)->name)) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label($locale . '[slug]', __('cms-core::admin.layout.Slug')) !!}
                        {!! Form::slugInput($locale . '[slug]', old($locale . '.slug', $obj->translateOrNew($locale)->slug), ['source' => 'input[name="' . $locale . '[name]"']) !!}
                    </div>
                @endLangTabs
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="py-2"><strong>@lang('cms-core::admin.layout.Main data')</strong></h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('published', __('cms-core::admin.layout.Published')) !!}
                            {!! Form::status('published') !!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('index', __('cms-localities::admin.Index')) !!}
                    {!! Form::text('index') !!}
                </div>
            </div>
        </div>
    </div>
</div>
