@php
    /**
     * @var $text string|null
     **/
@endphp

<div class="modal-content modal-content--size-xxl" @mousedown.away="isShow && close($event)">
    <div class="modal-body">
        <div class="_flex _justify-center _mb-md _lg:mb-df">
            <div class="logo logo--theme-yellow">
                @svg('logo', 'logo', [211, 39], 'logo__image')
            </div>
        </div>
        <div class="_mb-lg">
            <div class="text _fz-xxs _fw-bold _uppercase _color-base-strong _text-center">{!! $text !!}</div>
        </div>
        <div class="_flex _justify-center">
            <button class="button button--theme-yellow _b-r-sm _control-height-md _control-padding-md" x-on:click="close">
                <span>@lang('cms-ui::site.Готово')</span>
            </button>
        </div>
    </div>
</div>
