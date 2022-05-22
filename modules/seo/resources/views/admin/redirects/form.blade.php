<div class="row">
    <div class="col-lg-7">
        <div class="card mb-3">
            <div class="card-body">
                <div class="form-group">
                    {!! Form::label('name', __('cms-seo::admin.redirects.Name')) !!}
                    {!! Form::text('name') !!}
                </div>
                <div class="form-group">
                    {!! Form::label('link_from', __('cms-seo::admin.redirects.Link from')) !!}
                    <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top"
                       title="@lang('cms-seo::admin.redirects.Relative reference')"></i>
                    {!! Form::text('link_from') !!}
                </div>
                <div class="form-group">
                    {!! Form::label('link_to', __('cms-seo::admin.redirects.Link to')) !!}
                    {!! Form::text('link_to') !!}
                </div>
                <div class="form-group">
                    {!! Form::label('http_status', __('cms-seo::admin.redirects.HTTP status')) !!}
                    {!! Form::select('http_status', $httpStatuses) !!}
                </div>
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
            </div>
        </div>
    </div>
</div>
