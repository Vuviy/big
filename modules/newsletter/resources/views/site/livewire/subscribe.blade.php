<div>
    @if(!$isCurrentClientSubscribed)
        <div class="_mb-sm _md:mb-lg _lg:mb-xxl">
            <div class="footer-menu__title">@lang('cms-newsletter::site.Подписка на рассылку новостей / статей')</div>
            <div class="footer-menu__item _mb-xs">@lang('cms-newsletter::site.Подписывайтесь на наши новости!')</div>
            <form wire:submit.prevent="submit">
                <div class="subscribe-form__wrapper">
                    <input type="email"
                           name="email"
                           wire:model="email"
                           inputmode="email"
                           placeholder="@lang('cms-newsletter::site.Ваш email') *"
                    />
                    <button class="button button--theme-yellow _control-height-md _b-r-sm"
                            type="submit">@lang('cms-newsletter::site.Подписаться')</button>
                </div>
                @error('email')
                    <div class="form-item__error">{{ $message }}</div>
                @enderror
            </form>
        </div>
    @endif
</div>
