<div class="card mb-3">
    <div class="card-body">
        <div class="form-group">
            {!! Form::label('read', __('cms-contacts::admin.Status')) !!}
            {!! Form::status('read') !!}
        </div>
        <div class="form-group">
            {!! Form::label('name', __('cms-contacts::admin.Name')) !!}
            {!! Form::text('name') !!}
        </div>
        <div class="form-group">
            {!! Form::label('email', __('cms-contacts::admin.E-mail')) !!}
            {!! Form::email('email') !!}
        </div>
        <div class="form-group">
            {!! Form::label('message', __('cms-contacts::admin.Message')) !!}
            {!! Form::textarea('message') !!}
        </div>
    </div>
</div>
