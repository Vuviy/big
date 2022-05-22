<div class="row">
    <div class="col-md-12">
        <div class="card mb-3">
            <div class="card-body">
                <div class="form-group">
                    {!! Form::label('read', __('cms-callbacks::admin.Read')) !!}
                    {!! Form::status('read') !!}
                </div>
                <div class="form-group">
                    {!! Form::label('phone', __('cms-callbacks::admin.Phone')) !!}
                    {!! Form::text('phone') !!}
                </div>
            </div>
        </div>
    </div>
</div>
