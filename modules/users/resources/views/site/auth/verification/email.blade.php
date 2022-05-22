@extends('cms-ui::layouts.main')

@section('content')
    <div class="container">
        <h1>{{ SEO::getH1() }}</h1>
        <p>@lang('cms-users::site.Проверьте свою электронную почту')</p>
        <p>@lang('cms-users::site.Прежде чем продолжить, пожалуйста, проверьте ссылку подтверждения в своей электронной почте.')</p>
        <p>@lang('cms-users::site.Если вы не получили письмо'),
            <a href="{{ route('auth.verification.resend') }}">@lang('cms-users::site.нажмите здесь, чтобы запросить еще раз')</a>.
        </p>
        @include('cms-users::site.auth.verification.partials.logout')
    </div>
@endsection
