<div class="popup">
    <div>@lang('cms-users::site.Введите ваш email')</div>
    {!! Form::open(['route' => 'auth.password.reset', 'class' => 'js-import']) !!}
        <div>
            <input type="email"
                   name="login"
                   inputmode="email"
                   placeholder="@lang('cms-users::site.Ваш email') *"
                   required="required">
        </div>
        <button type="submit">@lang('cms-users::site.Восстановить')</button>
    {!! Form::close() !!}
    <span>@lang('cms-users::site.Вспомнили логин/пароль?')</span>
    <span class="js-import" data-mfp="ajax" data-mfp-src="{{ route('auth.login-form', Request::only('redirect')) }}">
        @lang('cms-users::site.Авторизация')
    </span>
</div>
