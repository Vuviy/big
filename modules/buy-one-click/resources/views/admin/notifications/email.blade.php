@component('mail::message')

# @lang('cms-buy-one-click::admin.email.New buy one click order')

### @lang('cms-buy-one-click::admin.email.Form data')
@component('mail::table')
| | |
|-|-|
| @lang('cms-buy-one-click::admin.email.Name'):  | {{ $order->name }} |
| @lang('cms-buy-one-click::admin.email.Phone'): | [{{ $order->phone }}](tel:{{ preg_replace('/[^\d\+]/', '', $order->phone) }})|
| @lang('cms-buy-one-click::admin.email.Product'): | [{{ $order->product->name }}]({{ $order->product->getFrontUrl() }})|
| @lang('cms-buy-one-click::admin.email.Count'): | {{ $order->count . ' ' . $order->unit() }}|
| @lang('cms-buy-one-click::admin.email.Created at'): | {{ $order->created_at ? $order->created_at->format('d.m.Y H:i:s') : '----' }} |
@endcomponent


@component('mail::button', ['url' => $urlToAdmin, 'color' => 'green'])
    @lang('cms-buy-one-click::admin.email.Go to admin panel')
@endcomponent

@endcomponent
