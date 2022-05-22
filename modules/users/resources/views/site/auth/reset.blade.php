@extends('cms-ui::layouts.main')

@php
    /**
     * @var $email null|string
     * @var $token null|string
     */
@endphp

@section('content')
    <div class="section section--off-b-lg">
        <div class="container">
            <h1 class="text _fz-xxl _fw-bold _color-black _mb-md">@lang('cms-users::site.Восстановление пароля')</h1>
            <div class="_grid">
                <div class="_cell--12 _md:cell--6 _df:cell--4">
                    {!! Form::open(['url' => route('auth.password.update', compact('token')), 'class' => 'js-import']) !!}
                        <div class="_grid _grid--1 _spacer _spacer--xs _mb-xs">
                        <div class="_cell">
                            @component('cms-ui::components.form.input', [
                                'name' => 'email',
                                'attributes' => [
                                    'value' . $email ?? old('email'),
                                    'inputmode=email',
                                ],
                                'label' => __('cms-users::site.Email') . '*',
                                'classes' => 'form-item--theme-base-weak _control-height-md _control-padding-xxs',
                                'type' => 'email',
                                'errors' => $errors
                            ])@endcomponent
                        </div>
                        <div class="_cell">
                            @component('cms-ui::components.form.input', [
                                'name' => 'password',
                                'attributes' => [
                                    'inputmode=password',
                                ],
                                'label' => __('cms-users::site.Новый пароль') . '*',
                                'classes' => 'form-item--theme-base-weak _control-height-md _control-padding-xxs',
                                'type' => 'password',
                                'errors' => $errors
                            ])@endcomponent
                        </div>
                        <div class="_cell">
                            @component('cms-ui::components.form.input', [
                                'name' => 'password_confirmation',
                                'attributes' => [
                                    'inputmode=password',
                                ],
                                'label' => __('cms-users::site.Повторите пароль') . '*',
                                'classes' => 'form-item--theme-base-weak _control-height-md _control-padding-xxs',
                                'type' => 'password',
                                'errors' => $errors
                            ])@endcomponent
                        </div>
                        <div class="_cell _mt-md">
                            <button type="submit" class="button button--theme-yellow _b-r-sm _control-height-md _control-padding-md">
                                <span>@lang('cms-users::site.Восстановить')</span>
                            </button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
