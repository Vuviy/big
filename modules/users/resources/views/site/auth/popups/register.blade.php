<div class="popup">
    <div>@lang('cms-users::site.Регистрация')</div>
    <div>@lang('cms-users::site.Вы сможете получить первые преимущества сразу после регистрации')</div>
    {!! Form::open(['url' => route('auth.register', Request::only('redirect')), 'class' => 'js-import']) !!}
        <div>
            <input type="text"
                   name="username"
                   placeholder="@lang('cms-users::site.Ваше имя') *"
                   inputmode="text"
                   spellcheck="true"
                   required="required">
        </div>
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
                   placeholder="@lang('cms-users::site.Придумайте пароль') *"
                   required="required">
        </div>
        <div>
            <input type="password"
                   name="password_confirmation"
                   minlength="{{ config('cms.users.users.password_min_length') }}"
                   placeholder="@lang('cms-users::site.Повторите пароль') *"
                   required="required">
        </div>
        <label>
            <input type="checkbox"
                   name="remember"
                   value="1"
                   required="required">
            <span>@lang('cms-users::site.Я согласен на обработку моих данных')</span>
            <a href="{{ route('privacy-policy') }}">@lang('cms-users::site.Подробнее')</a>
        </label>
        <div>
             <span class="js-import" data-mfp="ajax" data-mfp-src="{{ route('auth.login-form') }}">
                @lang('cms-users::site.Вход на сайт')
             </span>
            <button type="submit">@lang('cms-users::site.регистрация')</button>
        </div>
    {!! Form::close() !!}
    <div>@lang('cms-users::site.или')</div>
    @widget('cabinet-auth-socials', Request::only('redirect'))
</div>
