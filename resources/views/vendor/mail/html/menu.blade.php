@component('mail::partials.container')
    @if ($links ?? false)
    <td class="es-p10t es-p15b es-p20r es-p20l" align="left">
        <table width="100%" cellspacing="0" cellpadding="0">
            <tr>
                <td width="560" valign="top" align="center">
                    <table width="100%" cellspacing="0" cellpadding="0" role="presentation">
                        <tr>
                            <td>
                                <table class="es-menu" width="100%" cellspacing="0" cellpadding="0" role="presentation">
                                    <tr class="links">
                                        @foreach($links as $link)
                                        <td class="es-p5r es-p5l" width="{{ 100 / count($links) }}%" align="center">
                                            <a target="_blank" href="{{ $link['route'] }}">{{ $link['title'] }}</a>
                                        </td>
                                        @endforeach
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </td>
    @endif
@endcomponent

