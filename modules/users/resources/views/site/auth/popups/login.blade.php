<div class="popup">
    <div>@lang('cms-users::site.Вход на сайт')</div>
    <div>@lang('cms-users::site.Вы сможете получить первые преимущества сразу после входа')</div>
    {!! Form::open(['url' => route('auth.login', Request::only('redirect')), 'class' => 'js-import']) !!}
        <div>
            <input type="text"
                   name="login"
                   placeholder="@lang('cms-users::site.Ваш email или телефон') *"
                   required="required">
        </div>
        <div>
            <input type="password"
                   name="password"
                   minlength="{{ config('cms.users.users.password_min_length') }}"
                   placeholder="@lang('cms-users::site.Ваш пароль') *"
                   required="required"/>
        </div>
        <label>
            <input type="checkbox" name="remember" value="1">
            <span>@lang('cms-users::site.Запомнить меня')</span>
        </label>
        <div>
            <span class="js-import" data-mfp="ajax"
                  data-mfp-src="{{ route('auth.register-form', Request::only('redirect')) }}">@lang('cms-users::site.Регистрация')</span>
            <span class="js-import" data-mfp="ajax"
                  data-mfp-src="{{ route('auth.password.popup', Request::only('redirect')) }}">@lang('cms-users::site.Восстановить пароль')</span>
        </div>
        <div>
            <button>@lang('cms-users::site.Войти')</button>
        </div>
    {!! Form::close() !!}
    <div>@lang('cms-users::site.или')</div>
    @widget('cabinet-auth-socials', Request::only('redirect'))
</div>
