@php
    /**
     * @var $text string
     * @var $unsubscribe string
     */
@endphp
@component('mail::message')

{!! $text !!}

@component('mail::button', ['url' => $unsubscribe])
    @lang('cms-newsletter::site.email.To unsubscribe from the newsletter')
@endcomponent
@endcomponent
