@component('mail::message')

<?php
$title = '';
$introText = '';
$outroText = '';
if (! empty($greeting)) {
    $title = $greeting;
} else {
    $title = ($level === 'error') ? __('cms-ui::site.mail.whoops') : __('cms-ui::site.mail.hello');
}

foreach ($introLines as $line) {
    $introText = $introText . ' ' . $line;
}

foreach ($outroLines as $line) {
    $outroText = $outroText . ' ' . $line;
}
?>
{{-- Subject --}}
@if($subject ?? false)
@slot('header_title')
{{ $subject }}
@endslot
@endif

{{-- Greeting and Intro Lines --}}
@component('mail::partials.header_banner', [
    'title' => $title,
    'text' => $introText
])
@endcomponent

{{-- Action Button --}}
@isset($actionText)
@component('mail::button', ['url' => $actionUrl])
{{ $actionText }}
@endcomponent
@endisset

{{-- Outro Lines --}}
@if(strlen($outroText))
@component('mail::partials.header_banner', [
    'text' => $outroText
])
@endcomponent
@endif

{{-- Salutation --}}
@if (! empty($salutation))
@component('mail::panel')
{{ $salutation }}
@endcomponent
@endif

{{-- Subcopy --}}
@isset($actionText)
@slot('subcopy')
@component('mail::subcopy', ['actionUrl' => $actionUrl, 'displayableActionUrl' => $displayableActionUrl])
    @lang("cms-ui::site.mail.clicking_trouble_notice", ['actionText' => $actionText])
@endcomponent
@endslot
@endisset
@endcomponent
