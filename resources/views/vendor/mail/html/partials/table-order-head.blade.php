@component('mail::partials.container')
    <td class="es-p20t es-p20r es-p20l _bgcolor-2" align="left">
        <table cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td width="560" align="center" valign="top">
                    <table cellpadding="0" cellspacing="0" width="100%" role="presentation">
                        <tr>
                            <td align="left" class="es-m-txt-c es-p10t es-p5b">
                                <h1 class="table-order__title">
                                    <strong>{{ $title }}</strong>
                                </h1>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" class="es-p20t es-p20b table-order__text">
                                <p>{{ $text }}</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </td>
@endcomponent

@if($urlToCabinet ?? false)
@component('mail::partials.container')
    <td class="es-p20r es-p20l es-p30b _bgcolor-2" align="left">
        <!--[!if mso]><table width="560" cellpadding="0" cellspacing="0"><tr><td width="270" valign="top"><![endif]-->
        <table cellpadding="0" cellspacing="0" class="es-left" align="left">
            <tr>
                <td width="270" class="es-m-p20b" align="left">
                    <table cellpadding="0" cellspacing="0" width="100%" role="presentation">
                        <tr>
                            <td align="left" class="es-order-user-link">
                                <p>@lang('cms-ui::site.mail.Вы можете отследить статус заказа в')&nbsp;
                                    <a href="{{ $urlToCabinet }}" target="_blank">@lang('cms-ui::site.mail.личном кабинете')</a>.</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <!--[!if mso]></td><td width="20"></td><td width="270" valign="top"><![endif]-->
        <table cellpadding="0" cellspacing="0" class="es-right" align="right">
            <tr>
                <td width="270" align="left">
                    <table cellpadding="0" cellspacing="0" width="100%" role="presentation">
                        <tr>
                            <td align="right" class="es-m-txt-c">
                                <span class="es-button-border">
                                    <a href="{{ $urlToCabinet }}" class="es-button" target="_blank">{{ $urlToCabinetText }}</a>
                                </span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <!--[!if mso]></td></tr></table><![endif]-->
    </td>
@endcomponent
@endif

@component('mail::partials.container')
    <td align="center" class="es-p20r es-p20l _bgcolor-2 es-order-head">
        <table border="0" width="100%" cellpadding="0" cellspacing="0" role="presentation">
            <tr>
                <td class="es-order-head__line"></td>
            </tr>
            <tr>
                <td align="left" class="es-p20t es-p30b es-order-head__table">{{ Illuminate\Mail\Markdown::parse($slot) }}</td>
            </tr>
        </table>
    </td>
@endcomponent

@component('mail::partials.container')
    <td class="es-p20t es-p25b es-p20l _bgcolor-white" align="left">
        <table width="580" cellpadding="0" cellspacing="0"><tr><td width="290" valign="top">
        <table cellpadding="0" cellspacing="0" class="es-left" align="left">
            <tr>
                <td width="290" class="es-m-p20b" align="left">
                    <table cellpadding="0" cellspacing="0" width="100%" role="presentation">
                        <tr>
                            <td align="left" class="es-m-txt-c">
                                <h3>@lang('cms-ui::site.mail.Информация'):</h3>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" class="es-m-txt-c es-p10t">{{ Illuminate\Mail\Markdown::parse($orderInfo ?? '') }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        </td><td width="0"></td><td width="290" valign="top">
        <table cellpadding="0" cellspacing="0" class="es-right" align="right">
            <tr>
                <td width="290" align="left">
                    <table cellpadding="0" cellspacing="0" width="100%" role="presentation">
                        <tr>
                            <td align="left" class="es-m-txt-c">
                                <h3>@lang('cms-ui::site.mail.Доставка'):</h3>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" class="es-m-txt-c es-p10t es-p20r">{{ Illuminate\Mail\Markdown::parse($orderDelivery ?? '') }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        </td></tr></table>
    </td>
@endcomponent
