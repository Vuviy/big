@php
    /**
     * @var $obj WezomCms\Orders\Models\UserAddress
     * @var $users array
     */
@endphp
<div class="card mb-3">
    <div class="card-body">
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    {!! Form::label('user_id', __('cms-users::admin.Пользователь')) !!}
                    {!! Form::select('user_id', $users, null, ['class' => 'js-ajax-select2', 'data-url' => route('admin.users.search')])  !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('primary', __('cms-users::admin.Основной адрес')) !!}
                {!! Form::status('primary', null, false) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('city', __('cms-users::admin.Город')) !!}
                    {!! Form::text('city') !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('street', __('cms-users::admin.Улица')) !!}
                    {!! Form::text('street') !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('house', __('cms-users::admin.Дом')) !!}
                    {!! Form::text('house') !!}
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('room', __('cms-users::admin.Квартира')) !!}
                    {!! Form::number('room') !!}
                </div>
            </div>
        </div>
    </div>
</div>
