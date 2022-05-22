@php
    /**
     * @var $id int
     */
@endphp
<div class="popup">
    <div>@lang('cms-users::site.Сброс пароля')</div>
    <div>@lang('cms-users::site.Пожайлуста, введите код, который должен был прийти на указанный телефон.')</div>
    {!! Form::open(['url' => route('auth.password.update-by-code', compact('id')), 'class' => 'js-import']) !!}
        <div>
            <input type="text"
                   name="code"
                   autocomplete="off"
                   required="required"
                   placeholder="@lang('cms-users::site.Код') *">
        </div>
        <div>
            <input type="password"
                   name="password"
                   minlength="{{ config('cms.users.users.password_min_length') }}"
                   placeholder="@lang('cms-users::site.Новый пароль') *"
                   required="required">
        </div>
        <div>
            <input type="password"
                   name="password_confirmation"
                   minlength="{{ config('cms.users.users.password_min_length') }}"
                   placeholder="@lang('cms-users::site.Повторите пароль') *"
                   required="required">
        </div>
        <button type="submit">@lang('cms-users::site.Восстановить')</button>
    {!! Form::close() !!}
</div>
