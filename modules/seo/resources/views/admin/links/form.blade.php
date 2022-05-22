<div class="row">
    <div class="col-lg-7">
        <div class="card mb-3">
            <div class="card-body">
                <div class="form-group">
                    {!! Form::label('name', __('cms-seo::admin.links.Name')) !!}
                    {!! Form::text('name') !!}
                </div>
                <div class="form-group">
                    {!! Form::label('link', __('cms-seo::admin.links.Link')) !!}
                    <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top"
                       title="@lang('cms-seo::admin.links.Relative reference')"></i>
                    {!! Form::text('link') !!}
                </div>
                <div class="form-group">
                    {!! Form::label('title', __('cms-core::admin.seo.Title')) !!}
                    {!! Form::text('title') !!}
                </div>
                <div class="form-group">
                    {!! Form::label('h1', __('cms-core::admin.seo.H1')) !!}
                    {!! Form::text('h1') !!}
                </div>
                <div class="form-group">
                    {!! Form::label('keywords', __('cms-core::admin.seo.Keywords')) !!}
                    {!! Form::textarea('keywords',null, ['rows' => 3]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('description', __('cms-core::admin.seo.Description')) !!}
                    {!! Form::textarea('description',null, ['rows' => 3]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('seo_text', __('cms-core::admin.seo.Seo text')) !!}
                    {!! Form::textarea('seo_text', null, ['class' => 'js-wysiwyg'])  !!}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="py-2"><strong>@lang('cms-core::admin.layout.Main data')</strong></h5>
            </div>
            <div class="card-body">
                <div class="form-group">
                    {!! Form::label('published', __('cms-core::admin.layout.Published')) !!}
                    {!! Form::status('published') !!}
                </div>
            </div>
        </div>
    </div>
</div>
