<div class="footer-contacts">
    @if(!empty($settings['site']['work_time']))
        <div class="text _fz-def _fw-bold _lh-lg">
            @lang('cms-contacts::site.График работы'): {{ $settings['site']['work_time'] }}
        </div>
    @endif
        @if(!empty($settings['phones']['social_phone']))
            <div class="_grid _spacer _spacer--xs">
                <div class="_cell _cell--auto">
                    <div class="text _fz-def _fw-bold _lh-lg">
                        {{ $settings['phones']['social_phone'] }}<br>
                        @if(!empty($settings['phones']['phones']))
                            {!! nl2br($settings['phones']['phones']) !!}
                        @endif
                    </div>

                </div>
                <div class="_cell _cell--auto _pt-xs">
                    @widget('contacts:phone-social-links')
                </div>
            </div>
        @endif
        @if(!empty($settings['phones']['free_phone']))
            <div class="_grid _items-center _spacer _spacer--xs">
                <div class="_cell _cell--auto">
                    <div class="text _fz-def _fw-bold _lh-lg">
                        {{ $settings['phones']['free_phone'] }}
                    </div>
                </div>
                <div class="_cell _cell--auto">
                    <div class="text _color-pantone-gray">
                        @lang('cms-contacts::site.Бесплатно по Казахстану')
                    </div>
                </div>
            </div>
        @endif
</div>

