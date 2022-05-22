<div class="card mb-3">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-2 col-md-3 col-sm-4">
                <div class="form-group">
                    {!! Form::label('active', __('cms-newsletter::admin.Status')) !!}
                    {!! Form::status('active') !!}
                </div>
            </div>
            <div class="col-lg-10 col-md-9 col-sm-8">
                <div class="form-group">
                    {!! Form::label('locale', __('cms-newsletter::admin.Locale')) !!}
                    {!! Form::select('locale', $locales) !!}
                </div>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('email', __('cms-newsletter::admin.E-mail')) !!}
            {!! Form::email('email') !!}
        </div>
    </div>
</div>
