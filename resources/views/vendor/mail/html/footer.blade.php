@component('mail::partials.container', ['class' => 'es-footer-body'])

    <td class="es-p20t es-p20r es-p20l es-p20b es-footer-contacts"
        style="background-color: #1b2228;" align="left">
        <!--[if mso]>
        <table width="560" cellpadding="0" cellspacing="0">
            <tr>
                <td width="270" valign="top"><![endif]-->
        <table class="es-left" cellspacing="0" cellpadding="0" align="left">
            <tr>
                <td width="270" valign="top" align="center">
                    <table width="100%" cellspacing="0" cellpadding="0" role="presentation">
                        <tr>
                            <td align="left">
                                <a href="{{ $url }}" target="_blank">
                                    <img class="es-p10b" src="{{ asset('mail/logo_white.png') }}" alt/>
                                </a>
                                <br>
                                <span
                                    style="color:#FFFFFF;text-decoration:none!important;font-size: 14px">@lang('cms-ui::site.mail.Online store BIGPAYDA')</span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <!--[if mso]></td>
        <td width="20"></td>
        <td width="270" valign="top"><![endif]-->
        <table class="es-right" cellspacing="0" cellpadding="0" align="right">
            <tr>
                <td width="150" align="left">
                    <table width="100%" cellspacing="0" cellpadding="0" role="presentation">
                        <tr>
                            <td class="es-footer-shop-title">
                                @lang('cms-ui::site.mail.Интернет-магазин')
                            </td>
                        </tr>
                        <tr>
                            <td class="es-footer-phone">
                                {{ settings('contacts.phones.free_phone') }}
                            </td>
                        </tr>
                        <tr>
                            <td class="es-footer-schedule">
                                {!! settings('contacts.site.work_time') !!}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <!--[if mso]></td></tr></table><![endif]-->
    </td>
@endcomponent

@component('mail::partials.container')
    <td class="es-p20r es-p20l es-footer-develop" align="left">
        <table cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td width="560" align="center" valign="top">
                    <table cellpadding="0" cellspacing="0" width="100%" role="presentation">
                        <tr>
                            <td class="es-p10t es-p10b" align="center">
                                <p>{{ $slot }}<u style="font-size:0px;line-height: 0;">{{ now() }}</u></p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </td>
@endcomponent
