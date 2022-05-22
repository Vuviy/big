@component('mail::partials.container')
<td class="table-order es-p20 _bgcolor-2">
    {{ Illuminate\Mail\Markdown::parse($slot) }}
</td>
@endcomponent
