@component('mail::partials.container')
    @if($title)
    <td class="es-p10 _bgcolor-5 es-head" align="left">
        <table width="100%" cellspacing="0" cellpadding="0">
            <tr>
                <td width="580" valign="top" align="center">
                    <table width="100%" cellspacing="0" cellpadding="0" role="presentation">
                        <tr>
                            <td align="center">
                                <p>{{ $title }}</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </td>
    @endif
@endcomponent

@component('mail::partials.container')
    <td class="es-p10t es-p10b" align="left">
        <table cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td width="600" align="center" valign="top">
                    <table cellpadding="0" cellspacing="0" width="100%" role="presentation">
                        <tr>
                            <td class="es-p5t es-p5b" align="center" style="font-size: 0px">
                                <a href="{{ $url }}" target="_blank">
                                    <img src="{{ asset('mail/logo_black.png') }}" alt="{{ $slot }}"/>
                                </a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </td>
@endcomponent
