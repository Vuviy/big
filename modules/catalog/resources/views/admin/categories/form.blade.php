<div class="row">
    <div class="col-lg-7">
        <div class="card mb-3">
            <div class="card-body">
                @tabs([__('cms-catalog::admin.categories.Main data') => $viewPath.'.tabs.main-data', __('cms-catalog::admin.categories.SEO') => $viewPath.'.tabs.seo'])
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('published', __('cms-core::admin.layout.Published')) !!}
                            {!! Form::status('published') !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('show_on_main', __('cms-catalog::admin.categories.Show on main')) !!}
                            {!! Form::status('show_on_main', null, false) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('show_on_menu', __('cms-catalog::admin.categories.Show on menu')) !!}
                            {!! Form::status('show_on_menu', null, false) !!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('parent_id', __('cms-catalog::admin.categories.Parent')) !!}
                    {!! Form::select('parent_id', $tree, old('parent_id', $obj->parent_id ?: request()->get('parent_id')), ['class' => 'js-select2']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('SPECIFICATIONS[]', __('cms-catalog::admin.specifications.Specifications')) !!}
                    {!! Form::select('SPECIFICATIONS[]', $specifications, null, ['id' => 'specifications', 'class' => 'js-ajax-select2', 'data-url' => route('admin.specifications.search', ['multiple' => true]), 'data-minimum-input-length' => 0, 'multiple' => true]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('image', __('cms-catalog::admin.categories.Image')) !!}
                    {!! Form::imageUploader('image', $obj, route($routeName . '.delete-image', $obj->id)) !!}
                </div>
            </div>
        </div>
    </div>
</div>
