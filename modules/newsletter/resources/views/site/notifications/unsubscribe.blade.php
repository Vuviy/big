@component('mail::message')

@component('mail::partials.header_banner', [
    'title' => __('cms-newsletter::site.email.You have successfully unsubscribed from our newsletter'),
])
@endcomponent

@endcomponent
