@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url'),'title' => $header_title ?? null])
{{ config('app.name') }}
@endcomponent
@endslot

{{-- Menu --}}
@slot('menu')
    @component('mail::menu', [
        'links' => [
            ['route' => route('home'), 'title' => __('cms-ui::site.mail.Наш сайт')],
            ['route' => route('catalog'), 'title' => __('cms-ui::site.mail.Каталог')],
            ['route' => route('contacts'), 'title' => __('cms-ui::site.mail.Контакты')]
        ]
    ])
    @endcomponent
@endslot

{{-- Body --}}
{!! $slot !!}

{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
{{ $subcopy }}
@endslot
@endisset

{{-- Footer --}}
@slot('footer')
@component('mail::footer', ['url' => config('app.url')])
{{ date('Y') }}, @lang('cms-ui::site.mail.Bigpayda All rights reserved')
@endcomponent
@endslot
@endcomponent
