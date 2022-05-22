@php
    /**
     * @var $oldPassword string
     * @var $password string
     * @var $password_confirmation string
     */
@endphp

<div class="modal-content">
    <div class="h3 _mb-lg">@lang('cms-users::site.Изменение пароля')</div>
    <form wire:submit.prevent="submit">
        <div class="_grid _grid--1 _spacer _spacer--xs _mb-md">
            <div class="_cell">
                <div x-data="{ type: 'password' }" class="form-item form-item--input form-item--theme-base-weak _control-height-md _control-padding-xxs">
                    <div class="_flex _justify-between">
                        <div class="form-item__header _flex _justify-between _items-center _flex-grow">
                            <label for="password-input" class="form-item__label _text _fz-xs _color-faint-strong">@lang('cms-users::site.Текущий пароль') *</label>
                            <button type="button"
                                    class="button button--toggle-password _b-r-sm"
                                    @click="type = type === 'text' ? 'password' : 'text'"
                                    :class="{'is-active' : type === 'text'}"
                            >
                                <span class="button__icon">
                                    @svg('common', 'eye', 16)
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="form-item__body">
                        <input
                            name="oldPassword"
                            id="password-input"
                            :type="type"
                            value=""
                            wire:model.lazy="oldPassword"
                            wire:key="oldPassword"
                            autocomplete="password"
                            class="form-item__control {{ $errors->has('oldPassword') ? 'with-error' : null }}"
                        >
                    </div>

                    @if($errors->has('oldPassword'))
                        <label id="password-input-error" class="form-item__error" for="password-input">{{ $errors->first('oldPassword') }}</label>
                    @endif
                </div>
            </div>
            <div class="_cell">
                <div x-data="{ type: 'password' }" class="form-item form-item--input form-item--theme-base-weak _control-height-md _control-padding-xxs">
                    <div class="_flex _justify-between">
                        <div class="form-item__header _flex _justify-between _items-center _flex-grow">
                            <label for="password-input" class="form-item__label _text _fz-xs _color-faint-strong">@lang('cms-users::site.Новый пароль') *</label>
                            <button type="button"
                                    class="button button--toggle-password _b-r-sm"
                                    @click="type = type === 'text' ? 'password' : 'text'"
                                    :class="{'is-active' : type === 'text'}"
                            >
                                <span class="button__icon">
                                    @svg('common', 'eye', 16)
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="form-item__body">
                        <input
                            name="password"
                            id="password-input"
                            :type="type"
                            value=""
                            wire:model.lazy="password"
                            wire:key="password"
                            autocomplete="password"
                            class="form-item__control {{ $errors->has('password') ? 'with-error' : null }}"
                        >
                    </div>

                    @if($errors->has('password'))
                        <label id="password-input-error" class="form-item__error" for="password-input">{{ $errors->first('password') }}</label>
                    @endif
                </div>
            </div>
            <div class="_cell">
                <div x-data="{ type: 'password' }" class="form-item form-item--input form-item--theme-base-weak _control-height-md _control-padding-xxs">
                    <div class="_flex _justify-between">
                        <div class="form-item__header _flex _justify-between _items-center _flex-grow">
                            <label for="password-input" class="form-item__label _text _fz-xs _color-faint-strong">@lang('cms-users::site.Повторите новый пароль') *</label>
                            <button type="button"
                                    class="button button--toggle-password _b-r-sm"
                                    @click="type = type === 'text' ? 'password' : 'text'"
                                    :class="{'is-active' : type === 'text'}"
                            >
                                <span class="button__icon">
                                    @svg('common', 'eye', 16)
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="form-item__body">
                        <input
                            name="password_confirmation"
                            id="password-input"
                            :type="type"
                            value=""
                            wire:model.lazy="password_confirmation"
                            wire:key="password_confirmation"
                            autocomplete="password"
                            class="form-item__control {{ $errors->has('password_confirmation') ? 'with-error' : null }}"
                        >
                    </div>

                    @if($errors->has('password_confirmation'))
                        <label id="password-input-error" class="form-item__error" for="password-input">{{ $errors->first('password_confirmation') }}</label>
                    @endif
                </div>
            </div>
        </div>
        <div class="_grid _spacer _spacer--sm">
            <div class="_cell _cell--auto">
                <button type="button" class="button button--theme-transparent-bordered _px-sm _control-height-md _b-r-sm _flex-grow"
                        x-on:click="$dispatch('close-modal')"
                >
                    <span class="_fz-xs">@lang('cms-users::site.Отменить')</span>
                </button>
            </div>
            <div class="_cell _cell--auto _flex _flex-grow">
                <button type="submit" class="button button--theme-yellow _control-height-md _b-r-sm _flex-grow">
                    <span class="button__text">@lang('cms-users::site.Сохранить изменения')</span>
                </button>
            </div>
        </div>
    </form>
</div>
