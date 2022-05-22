@component('mail::partials.container')
<td class="table">
{{ Illuminate\Mail\Markdown::parse($slot) }}
</td>
@endcomponent
