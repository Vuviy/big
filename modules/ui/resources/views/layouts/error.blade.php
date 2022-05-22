@extends('cms-ui::layouts.base')

@section('main')
    <div class="section section--off-t-lg section--off-b-lg">
        <div class="container">
            <div class="text _fz-xxl _fw-bold _color-black">@lang('cms-ui::site.Ошибка') @yield('code', 404)</div>
            <div class="_mb-sm">
                <img src="{{ url('/images/empty-pages/404.svg') }}" alt="error">
            </div>
            <div class="text _fz-xxs _color-black _fw-bold _text-center _uppercase _mb-md">@yield('message')</div>
            @if(starts_with($__env->yieldContent('code', 404), '4'))
                <div>@yield('text')</div>
            @endif
            <div class="_flex _justify-center">
                <a class="button button--theme-black _control-height-md _b-r-sm _px-md" href="{{ route('home') }}">@lang('cms-favorites::site.Перейти на главную')</a>
            </div>
        </div>
    </div>
@endsection
