@component('mail::partials.container')
    <td class="es-p20r es-p20l _bgcolor-2" align="left">
        <table cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td width="560" align="center" valign="top">
                    <table class="subcopy" cellpadding="0" cellspacing="0" width="100%" role="presentation">
                        <tr>
                            <td class="es-p10r es-p10l" align="center">
                                <p>{{ $slot }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="es-p20b es-p40r es-p40l" align="center">
                                <p>
                                    <a href="{{ $actionUrl }}" target="_blank">
                                        <u>{{ $displayableActionUrl }}</u>
                                    </a>
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </td>
@endcomponent
