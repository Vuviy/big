@php
    /**
     * @var $unsubscribe string
     */
@endphp
@component('mail::message')

@component('mail::partials.header_banner', [
    'title' => __('cms-newsletter::site.email.You have successfully subscribed to our newsletter'),
    'text' => __('cms-newsletter::site.email.To unsubscribe, follow the link:')
])
@endcomponent

@component('mail::button', ['url' => $unsubscribe])
    @lang('cms-newsletter::site.email.Unsubscribe')
@endcomponent

@endcomponent
