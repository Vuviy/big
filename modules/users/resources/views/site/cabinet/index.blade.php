@extends('cms-users::site.layouts.cabinet')

@section('content')

<h2 class="_fz-def _fw-bold _mt-none _mb-sm">@lang('cms-users::site.cabinet.Личные данные')</h2>
<livewire:users.cabinet.edit-personal-info :user="$user" />
<hr class="separator separator--horizontal separator--theme-faint-weak _my-sm _md:my-df">
<h2 class="_fz-def _fw-bold _mt-none _mb-sm">@lang('cms-users::site.cabinet.Контакты')</h2>
<livewire:users.cabinet.edit-contact-info :user="$user" />
<hr class="separator separator--horizontal separator--theme-faint-weak _my-sm _md:my-df">
<h2 class="_fz-def _fw-bold _mt-none _mb-sm">@lang('cms-users::site.cabinet.Адрес доставки')</h2>
<livewire:users.cabinet.edit-addresses />
<hr class="separator separator--horizontal separator--theme-faint-weak _my-sm _md:my-df">
<button type="button"
        x-data="app.alpine.openModal('users.change-password')"
        x-on:click="open"
        x-on:mouseenter="open"
        class="_flex _items-center _fz-sm _color-pantone-gray _fw-medium"
>
    <span class="_mr-xs">
        @lang('cms-users::site.Изменить пароль')
    </span>
</button>
@endsection
