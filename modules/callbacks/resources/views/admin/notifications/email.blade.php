@component('mail::message')

# @lang('cms-callbacks::admin.email.New callback order')

### @lang('cms-callbacks::admin.email.Form data')
@component('mail::table')
| | |
|-|-|
| @lang('cms-callbacks::admin.email.Name'):  | {{ $order->name }} |
| @lang('cms-callbacks::admin.email.Phone'): | [{{ $order->phone }}](tel:{{ preg_replace('/[^\d\+]/', '', $order->phone) }})|
| @lang('cms-callbacks::admin.email.Created at'): | {{ $order->created_at ? $order->created_at->format('d.m.Y H:i:s') : '----' }} |
@endcomponent


@component('mail::button', ['url' => $urlToAdmin, 'color' => 'green'])
    @lang('cms-callbacks::admin.email.Go to admin panel')
@endcomponent

@endcomponent
