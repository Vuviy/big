@php
    /**
     * @var $phone string|null
     */
@endphp
<div class="modal-content" @mousedown.away="isShow && close($event)">
    <form wire:submit.prevent="submit">
        <div class="text _fz-xxs _fw-bold _mb-sm">
            @lang('cms-callbacks::site.CALL-ЦЕНТР')
        </div>
        @if(!empty($settings['site']['work_time']))
            <div class="text _fz-xxxs _color-base-strong _mb-xs">{{ $settings['site']['work_time'] }}</div>
        @endif
        <div class="text _fz-xs _color-black _mb-xs">@lang('cms-callbacks::site.Проконсультируем по телефонам')</div>
        <div>
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
                <div class="_grid _items-center _spacer _spacer--xs _mb-xs">
                    <div class="_cell _cell--auto">
                        <div class="text _fz-def _fw-bold _lh-lg">
                            {{ $settings['phones']['free_phone'] }}
                        </div>
                    </div>
                    <div class="_cell _cell--auto">
                        <div class="text _color-pantone-gray _fz-xxxs">
                            @lang('cms-contacts::site.Бесплатно по Казахстану')
                        </div>
                    </div>
                </div>
                <hr class="separator separator--horizontal separator--offset-sm">
            @endif
        </div>
        <div class="text _fz-xs _color-black _mb-xs">@lang('cms-callbacks::site.Мы  вам перезвоним')</div>
        <div class="_grid _spacer _spacer--sm">
            <div class="_cell _cell--12">
                <x-ui-phone-input :value="$phone" :label="__('cms-callbacks::site.Телефон')" />
            </div>
            <div class="_cell _cell--12 _flex">
                <button class="button button--theme-yellow _b-r-sm _control-height-md _control-padding-xs _control-space-md _flex-grow"
                        type="submit"
                >
                    <span class="button__text">
                        @lang('cms-callbacks::site.Перезвоните мне')
                    </span>
                </button>
            </div>
            <div class="_cell _cell--12">
                <span class="_flex _flex-column _items-center">
                    <span class="text _fz-xs _color-black">@lang('cms-users::site.Нажимая на кнопку, ты соглашаешься с')</span>

                    <a href="{{ route('privacy-policy') }}" target="_blank" rel="noopener" class="link _fz-xs _color-pantone-gray _underline">
                        <span class="link__text">
                            @lang('cms-users::site.пользовательским соглашением')
                        </span>
                    </a>
                </span>
            </div>
        </div>
    </form>
</div>
