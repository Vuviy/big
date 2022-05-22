<form
    wire:submit.prevent="submit"
    id="login-form"
>
    <div class="_grid _grid--1 _spacer _spacer--xs">
        <div class="_cell">
            @component('cms-ui::components.form.input', [
                'name' => 'login',
                'attributes' => [
                    'wire:model.lazy=login',
                    'wire:key=login',
                    'autocomplete=email'
                ],
                'label' => __('cms-users::site.Email'),
                'classes' => 'form-item--theme-base-weak _control-height-md _control-padding-xxs',
                'type' => 'email'
            ])@endcomponent
        </div>
        <div class="_cell">
            <div x-data="{ type: 'password' }" class="form-item form-item--input form-item--theme-base-weak _control-height-md _control-padding-xxs">
                <div class="_flex _justify-between">
                    <div class="form-item__header _flex _justify-between _items-center _flex-grow">
                        <label for="password-input" class="form-item__label _text _fz-xs _color-faint-strong">@lang('cms-users::site.Пароль')</label>
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

                @if ($errors->has('password'))
                    <label id="password-input-error" class="form-item__error" for="password-input">{{ $errors->first('password') }}</label>
                @endif
            </div>
        </div>
    </div>


    <div class="_flex _justify-end _mt-xs _pb-xs">
        <div @click="$parent.open('reset')" class="link link--theme-gray link--no-decoration">@lang('cms-users::site.Напомнить пароль')</div>
    </div>

    <div class="_flex">
        <button type="submit" class="button button--theme-yellow _control-height-md _b-r-sm _flex-grow">
            <span class="button__text">@lang('cms-users::site.Войти')</span>
        </button>
    </div>
</form>
