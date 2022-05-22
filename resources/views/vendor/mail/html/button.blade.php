@component('mail::partials.container')
    <td class="es-p20r es-p20l _bgcolor-2" align="left">
        <table cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td width="560" align="center" valign="top">
                    <table cellpadding="0" cellspacing="0" width="100%" role="presentation">
                        <tr>
                            <td class="es-p25t es-p25b es-p10r es-p10l" align="center">
<!--[if gte mso 9]>
<table border="0" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;min-width:100%!important;">
<tr>
<td align="center">
<![endif]-->
<span class="es-button-border">
<a href="{{ $url }}" class="es-button {{ $color ?? false ? 'es-button-' . $color : '' }}" target="_blank">{{ $slot }}</a>
</span>
<!--[if gte mso 9]>
</td>
</tr>
</table>
<![endif]-->
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </td>
@endcomponent
