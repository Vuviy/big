@component('mail::partials.container')
<td class="table-order es-p20l es-p20r es-p20t es-p10b _bgcolor-2">
{{ Illuminate\Mail\Markdown::parse($slot) }}
</td>
@endcomponent
