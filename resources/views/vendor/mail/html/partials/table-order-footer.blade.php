@component('mail::partials.container')
    <td align="center" class="es-p20r es-p20l _bgcolor-2 es-order-head">
        <table border="0" width="100%" cellpadding="0" cellspacing="0" role="presentation">
            <tr>
                <td class="es-order-head__line"></td>
            </tr>
            <tr>
                <td align="left" class="es-p20t es-p30b es-order-head__content">{{ Illuminate\Mail\Markdown::parse($userInfo ?? '') }}</td>
            </tr>
        </table>
    </td>
@endcomponent
@component('mail::partials.container')
    <td width="600" align="center" valign="top">
        <table cellpadding="0" cellspacing="0" width="100%" role="presentation">
            <tr>
                <td class="es-p25t es-p25b es-p20l es-p20r es-total-price _bgcolor-white" align="left">
                    <table cellpadding="0" cellspacing="0" width="100%" role="presentation">
                        <tr>
                            <td align="left"><span>@lang('cms-ui::site.mail.Итого к оплате')</span></td>
                            <td align="right"><strong>{{ $slot }}</strong></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </td>
@endcomponent
@if(trim($paymentButton ?? ''))
@component('mail::partials.container')
    <td class="es-p20 _bgcolor-6 es-payment" align="left">
        <!--[if mso]><table width="560" cellpadding="0" cellspacing="0"><tr><td width="356" valign="top"><![endif]-->
        <table class="es-left" cellspacing="0" cellpadding="0" align="left">
            <tr>
                <td class="es-m-p20b" width="356" align="left">
                    <table width="100%" cellspacing="0" cellpadding="0" role="presentation">
                        <tr>
                            <td class="es-p15t es-p15b" align="left">
                                <p>@lang('cms-ui::site.mail.Вы можете оплатить заказ сейчас, через наш сервис')</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <!--[if mso]></td><td width="20"></td><td width="184" valign="top"><![endif]-->
        <table cellspacing="0" cellpadding="0" align="right">
            <tr>
                <td width="184" align="left">
                    <table width="100%" cellspacing="0" cellpadding="0" role="presentation">
                        <tr>
                            <td align="right" class="es-m-txt-c">
                                <span class="es-button-border">{{ Illuminate\Mail\Markdown::parse($paymentButton) }}</span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <!--[if mso]></td></tr></table><![endif]-->
    </td>
@endcomponent
@endif
