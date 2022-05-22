<div class="row">
    <div class="col-lg-6">
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="py-2"><strong>@lang('cms-core::admin.layout.Main data')</strong></h5>
            </div>
            <div class="card-body form-horizontal">
                <div class="form-group">
                    <div class="row">
                        {!! Form::label('name', __('cms-users::admin.Name'), ['class' => 'col-sm-3']) !!}
                        <div class="col-sm-9">{!! Form::text('name') !!}</div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        {!! Form::label('surname', __('cms-users::admin.Surname'), ['class' => 'col-sm-3']) !!}
                        <div class="col-sm-9">{!! Form::text('surname') !!}</div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        {!! Form::label('email', __('cms-users::admin.E-mail'), ['class' => 'col-sm-3']) !!}
                        <div class="col-sm-9">{!! Form::email('email') !!}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="py-2"><strong>@lang('cms-users::admin.Password')</strong></h5>
                @if($obj->id ?? false)
                    <div class="dib">
                        <a href="{{ route('admin.users.auth', $obj->id) }}" class="btn btn-sm btn-info" target="_blank"
                           data-toggle="tooltip"
                           title="@lang('cms-users::admin.log in as user')">@lang('cms-users::admin.Login')</a>
                    </div>
                @endif
            </div>
            <div class="card-body form-horizontal">
                <div class="form-group">
                    <div class="row">
                        {!! Form::label('password', __('cms-users::admin.Password'), ['class' => 'col-sm-3']) !!}
                        <div class="col-sm-9">{!! Form::password('password', ['autocomplete' => 'new-password']) !!}</div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        {!! Form::label('password_confirmation', __('cms-users::admin.Confirm password'), ['class' => 'col-sm-3']) !!}
                        <div class="col-sm-9">{!! Form::password('password_confirmation', ['autocomplete' => 'new-password']) !!}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="py-2"><strong>@lang('cms-users::admin.Additionally')</strong></h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('active', __('cms-users::admin.Status')) !!}
                            {!! Form::status('active') !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('email_verified', __('cms-users::admin.Email verified')) !!}
                            {!! Form::status('email_verified', old('email_verified', $obj->email_verified_at ? true : false), true, __('cms-users::admin.Yes'), __('cms-users::admin.No'))  !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('phone', __('cms-users::admin.Phone')) !!}
                            {!! Form::text('phone')  !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('birthday', __('cms-users::admin.Дата рождения')) !!}
                            {!! Form::text('birthday', old('birthday', $obj->birthday ? $obj->birthday->format('d.m.Y') : null), ['class' => 'js-datepicker']) !!}
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('communication[]', __('cms-users::admin.communication.Preferred communication methods')) !!}
                    {!! Form::select('communication[]', $communicationTypes, old('communication', $selectedCommunications), ['class' => 'js-select2', 'multiple' => 'multiple']) !!}
                </div>
            </div>
        </div>
    </div>
</div>
