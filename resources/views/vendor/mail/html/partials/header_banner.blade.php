@component('mail::partials.container', ['class' => 'es-content-header'])
    <td class="es-p15t es-p30b es-p20r es-p20l _bgcolor-2" align="left">
        <table width="100%" cellspacing="0" cellpadding="0">
            <tr>
                <td width="560" valign="top" align="center">
                    <table width="100%" cellspacing="0" cellpadding="0" role="presentation">
                        @if($title ?? false)
                            <tr>
                                <td class="es-p15t es-p15b" align="center">
                                    <h1>
                                        <strong>{{ $title }}</strong>
                                    </h1>
                                </td>
                            </tr>
                        @endif
                        @if($text ?? false)
                            <tr>
                                <td class="es-p40r es-p40l" align="center">
                                    <p>{{ $text }}</p>
                                </td>
                            </tr>
                        @endif
                    </table>
                </td>
            </tr>
        </table>
    </td>
@endcomponent
