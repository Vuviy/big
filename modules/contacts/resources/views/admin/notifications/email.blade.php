@component('mail::message')

# @lang('cms-contacts::admin.email.New request with the contact form')

### @lang('cms-contacts::admin.email.Form data')
@component('mail::table')
| | |
|-|-|
| @lang('cms-contacts::admin.email.Name'):  | {{ $contact->name }} |
| @lang('cms-contacts::admin.email.E-mail'): | [{{ $contact->email }}](mailto:{{ $contact->email }})|
| @lang('cms-contacts::admin.email.Created at'): | {{ $contact->created_at ? $contact->created_at->format('d.m.Y H:i:s') : '----' }} |
@endcomponent

@lang('cms-contacts::admin.email.Message')
@component('mail::panel')
    {{ $contact->message }}
@endcomponent

@component('mail::button', ['url' => $urlToAdmin, 'color' => 'green'])
    @lang('cms-contacts::admin.email.Go to admin panel')
@endcomponent

@endcomponent
