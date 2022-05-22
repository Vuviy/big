@php
    /**
     * @var $privacyPolicyLoaded bool
     * @var $product \WezomCms\Catalog\Models\Product|\WezomCms\Orders\Contracts\PurchasedProductInterface
     */
@endphp
<div class="modal-content" @mousedown.away="isShow && close($event)">
    <div class="_flex _items-center _justify-between _mb-xs">
        <div class="text _fz-xxs _fw-bold _uppercase _color-base-strong">
            @lang('cms-buy-one-click::site.Купить в 1 клик')
        </div>
    </div>
    <div class="modal-body">
        <div class="text _fz-sm _color-black _mb-sm">@lang('cms-buy-one-click::site.Оставьте свой номер и мы вам перезвоним')</div>

        <form wire:submit.prevent="submit">
            <div class="_mb-sm">
                <x-ui-phone-input :value="$phone"
                                  name="phone"
                                  :label="__('cms-buy-one-click::site.Моб. телефон')"
                                  :placeholder="__('cms-ui::site.inputPhonePlaceholder')"
                />
            </div>
            <div class="_flex _mb-sm">
                <button type="submit" class="button button--theme-yellow _control-height-md _b-r-sm _flex-grow">
                    <span class="button__text">@lang('cms-buy-one-click::site.Перезвоните мне')</span>
                </button>
            </div>
        </form>
{{--        @if($privacyPolicyLoaded)--}}
            <div class="_flex _flex-column _items-center">
                <span class="_flex _flex-column _items-center">
                    <span class="text _fz-xs _color-black">@lang('cms-users::site.Нажимая на кнопку, ты соглашаешься с')</span>

                    <a href="{{ route('privacy-policy') }}" target="_blank" rel="noopener" class="link _fz-xs _color-pantone-gray _underline">
                        <span class="link__text">
                            @lang('cms-users::site.пользовательским соглашением')
                        </span>
                    </a>
                </span>
            </div>
{{--        @endif--}}
    </div>
</div>
