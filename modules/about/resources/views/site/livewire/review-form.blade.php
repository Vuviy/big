<div>
    <div class="_text-center text _fw-bold _fz-xl _mb-df _df:mb-lg _md:pb-sm">
        @lang('cms-about::site.Оставить отзыв о работе с компанией')
    </div>
    <form novalidate="novalidate" wire:submit.prevent="submit">
        <div class="_grid _grid--1 _md:grid--2 _spacer _spacer--sm">
            <div class="_cell">
                <div class="form-item form-item--input form-item--theme-base-weak _control-height-md _control-padding-xxs">
                    <div class="form-item__header">
                        <label for="reviews-name" class="form-item__label _text _fz-xxxs _color-faint-strong">@lang('cms-about::site.Your name')</label>
                    </div>
                    <div class="form-item__body">
                        <input
                            name="name"
                            id="reviews-name"
                            type="text"
                            value="{{ $name ?? '' }}"
                            placeholder="@lang('cms-about::site.Your name')"
                            class="form-item__control text _fz-sm _color-pantone-gray {{ $errors->has('name') ? 'has-error' : null }}"
                            wire:model.lazy="name" wire:key="name"
                        >
                    </div>
                    @error('name')
                    <label id="reviews-name-error" class="form-item__error" for="reviews-name">{{ $message }}</label>
                    @enderror
                </div>
            </div>
            <div class="_cell">
                <div class="form-item form-item--input form-item--theme-base-weak _control-height-md _control-padding-xxs">
                    <div class="form-item__header">
                        <label for="reviews-name" class="form-item__label _text _fz-xxxs _color-faint-strong">@lang('cms-about::site.Email')</label>
                    </div>
                    <div class="form-item__body">
                        <input
                            name="email"
                            id="reviews-email"
                            type="text"
                            value="{{ $email ?? '' }}"
                            placeholder="@lang('cms-about::site.Email')"
                            class="form-item__control text _fz-sm _color-pantone-gray {{ $errors->has('email') ? 'has-error' : null }}"
                            wire:model.lazy="email" wire:key="email"
                        >
                    </div>
                    @error('email')
                    <label id="reviews-email-error" class="form-item__error" for="reviews-email">{{ $message }}</label>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-item form-item--textarea form-item--theme-base-weak _control-height-md _control-padding-xxs _my-sm" data-form-item>
            <label for="reviews-text" class="form-item__label _text _fz-xxxs _color-faint-strong">@lang('cms-about::site.Your feedback')</label>
            <div class="form-item__body">
        <textarea
            name="text"
            id="reviews-text"
            wire:model.lazy="text" wire:key="text"
            placeholder="@lang('cms-about::site.Your feedback')"
            class="form-item__control text _fz-sm _color-pantone-gray"
            data-form-el>{{ $text ?? '' }}</textarea>
            </div>
            @error('text')
            <label id="reviews-text-error" class="has-error" for="reviews-text">{{ $message }}</label>
            @enderror
        </div>

        <div class="checkbox checkbox--default _mb-sm">
            <input class="checkbox__control"
                   type="checkbox"
                   name="notify"
                   id="notify"
                   wire:model="notify"
                   wire:key="notify"
            >
            <label class="checkbox__label" for="notify">
                    <span class="checkbox__checkmark">
                        @svg('common', 'checkmark', [12,12])
                    </span>
                <span class="checkbox__text _fz-xs _color-black">@lang('cms-about::site.Notify of replies by email')</span>
            </label>
            @error('notify')
            <span class="form-item__error">{{ $message }}</span>
            @enderror
        </div>

        <button class="button button--theme-yellow button--full-width _control-height-md _b-r-sm" type="submit">
            @lang('cms-about::site.Отправить')
        </button>
    </form>
</div>
