@extends('cms-ui::layouts.main')

@section('content')
    <div class="container">
        <h1>{{ SEO::getH1() }}</h1>
        <p>@lang('cms-users::site.Подтвердите свой телефон')</p>
        {!! Form::open(['route' => 'auth.verification.verify-phone', 'class' => 'js-import']) !!}
            <div>
                <input type="text"
                       name="code"
                       autocomplete="off"
                       placeholder="@lang('cms-users::site.Введите код') *"
                       required="required">
            </div>
            <button type="submit">@lang('cms-users::site.Отправить')</button>
        {!! Form::close() !!}
        <p>@lang('cms-users::site.Прежде чем продолжить, пожалуйста, проверьте ваши смс на наличие актуального кода подтверждения.')</p>
        <p>@lang('cms-users::site.Если вы не получили сообщение'),
            <a href="{{ route('auth.verification.resend') }}">@lang('cms-users::site.нажмите здесь, чтобы запросить еще раз')</a>.
        </p>
        @include('cms-users::site.auth.verification.partials.logout')
    </div>
@endsection
