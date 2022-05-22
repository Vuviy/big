<div class="row">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('name', __('cms-about::admin.Name')) !!}
                            {!! Form::text('name') !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('email', __('cms-about::admin.E-mail')) !!}
                            {!! Form::text('email') !!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('text', __('cms-about::admin.Text')) !!}
                    {!! Form::textarea('text') !!}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('published', __('cms-core::admin.layout.Published')) !!}
                            {!! Form::status('published') !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('notify', __('cms-about::admin.Notify about replies')) !!}
                            {!! Form::status('notify', null, false) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
