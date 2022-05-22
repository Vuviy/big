@php
    /**
     * @var $userInfo array
     */
@endphp

<div>
    @error('user.email_auth')
        <div class="box box--inform _mb-md _lg:mb-df">
            <div class="_flex _items-center">
                <div class="text _fz-xs _color-black">@lang('cms-orders::site.Такой пользователь уже есть'),&nbsp </div>
                <div
                    x-data="app.alpine.openModal('users.auth-modal', {{ json_encode(['redirect' => route('checkout')]) }})"
                    @click="open"
                    @mouseenter="open"
                    class="link link--theme-gray link--with-decoration _mr-sm"
                >
                    <div class="link__text text _fz-xs">
                        @lang('cms-orders::site.авторизуйся')
                    </div>
                </div>
                <div class="tooltip js-dmi"
                     data-tippy
                     data-template="authorize"
                >
                    <div class="tooltip__icon icon">
                        @svg('common', 'info', 16)
                    </div>
                    <template id="authorize">
                        <div class="tooltip__text text _fz-xxxxs _letter-spacing-def _color-white">
                            @lang('cms-orders::site.Tooltip текст для блока авторизуйся')
                        </div>
                    </template>
                </div>
            </div>
        </div>
    @enderror

    <div class="_grid _spacer _spacer--sm _items-center _mb-none">
        <div class="_cell">
            <div class="step-counter">
                <div class="text _color-white">1</div>
            </div>
        </div>
        <div class="_cell">
            <div class="text _fz-def _fw-bold _color-black">@lang('cms-orders::site.Контактные данные')</div>
        </div>
        @guest
            <div class="_cell _df:ml-auto">
                <div class="_flex _items-center">
                    <div class="text _fz-xs _color-black">@lang('cms-orders::site.Постоянный клиент')?&nbsp</div>
                    <span
                        x-data="app.alpine.openModal('users.auth-modal', {{ json_encode(['redirect' => route('checkout')]) }})"
                        @click="open"
                        @mouseenter="open"
                        class="link link--theme-gray link--with-decoration"
                    >
                        <span class="link__text text _fz-xs">
                            @lang('cms-orders::site.Войти')
                        </span>
                    </span>
                </div>
            </div>
        @endguest
    </div>
    <div class="_grid _spacer _spacer--sm _mb-none">
        <div class="_cell _cell--12 _sm:cell--6 _md:cell--12 _df:cell--6">
            @component('cms-ui::components.form.input', [
                'name' => 'user.name',
                'attributes' => [
                    'wire:model.lazy=user.name',
                    'wire:key=user.name',
                    'autocomplete=username'
                ],
                'label' => __('cms-orders::site.auth.Name') . '*',
                'classes' => 'form-item--theme-base-weak _control-height-md _control-padding-xxs',
                'type' => 'text'
            ])@endcomponent
        </div>
        <div class="_cell _cell--12 _sm:cell--6 _md:cell--12 _df:cell--6">
            @component('cms-ui::components.form.input', [
                'name' => 'user.surname',
                'attributes' => [
                    'wire:model.lazy=user.surname',
                    'wire:key=user.surname'
                ],
                'label' => __('cms-orders::site.auth.Surname') . '*',
                'classes' => 'form-item--theme-base-weak _control-height-md _control-padding-xxs',
                'type' => 'text'
            ])@endcomponent
        </div>
        <div class="_cell _cell--12 _sm:cell--6 _md:cell--12 _df:cell--6">
            @component('cms-ui::components.form.input', [
                'name' => 'user.email',
                'attributes' => [
                    'wire:model.lazy=user.email',
                    'wire:key=user.email',
                    'autocomplete=email'
                ],
                'label' => __('cms-users::site.Email') . '*',
                'classes' => 'form-item--theme-base-weak _control-height-md _control-padding-xxs',
                'type' => 'email'
            ])@endcomponent
        </div>
        <div class="_cell _cell--12 _sm:cell--6 _md:cell--12 _df:cell--6">
            <x-ui-phone-input :name="'user.phone'" :value="array_get($user, 'phone')" :label="__('cms-orders::site.checkout.Phone') . '*'" />
        </div>
        @guest
            <div class="_cell _cell--12">
                <div x-data="{ show: false}">
                    <div class="checkbox checkbox--default _mb-sm">
                        <input class="checkbox__control"
                               type="checkbox"
                               name="user.registerMe"
                               id="user.registerMe"
                               wire:model.lazy="user.registerMe"
                               wire:key="user.registerMe"
                               @click="show = !show"
                        >
                        <label class="checkbox__label" for="user.registerMe">
                    <span class="checkbox__checkmark">
                        @svg('common', 'checkmark', [12,12])
                    </span>
                            <span class="checkbox__text _fz-xs _color-black">@lang('cms-orders::site.auth.Register me')</span>
                        </label>
                        @error('user.registerMe')
                        <span class="form-item__error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div x-show.transition.in.duration.500ms.out.duration.300ms="show">
                        <div class="_grid _spacer _spacer--sm">
                            <div class="_cell _cell--12 _sm:cell--6 _md:cell--12 _df:cell--6">
                                <div x-data="{ type: 'password' }"
                                     class="form-item form-item--input form-item--theme-base-weak _control-height-md _control-padding-xxs _mb-xs"
                                >
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
                                            name="user.password"
                                            id="password-input"
                                            :type="type"
                                            value=""
                                            wire:model.lazy="user.password"
                                            wire:key="user.password"
                                            autocomplete="password"
                                            class="form-item__control {{ $errors->has('password') ? 'with-error' : null }}"
                                        >
                                    </div>

                                    @if ($errors->has('user.password'))
                                        <label id="password-input-error" class="form-item__error" for="password-input">{{ $errors->first('user.password') }}</label>
                                    @endif
                                </div>
                                <div class="text _fz-xxxs _color-faint-strong">@lang('cms-orders::site.Пароль должен быть не менее 6 символов').</div>
                            </div>
                            <div class="_cell _cell--12 _sm:cell--6 _md:cell--12 _df:cell--6">
                                <div x-data="{ type: 'password' }"
                                     class="form-item form-item--input form-item--theme-base-weak _control-height-md _control-padding-xxs _mb-xs"
                                >
                                    <div class="_flex _justify-between">
                                        <div class="form-item__header _flex _justify-between _items-center _flex-grow">
                                            <label for="user.password_confirmation" class="form-item__label _text _fz-xs _color-faint-strong">@lang('cms-users::site.Подтвердите пароль')</label>
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
                                            name="user.password_confirmation"
                                            id="user.password_confirmation"
                                            :type="type"
                                            value=""
                                            wire:model.lazy="user.password_confirmation"
                                            wire:key="user.password_confirmation"
                                            autocomplete="password"
                                            class="form-item__control {{ $errors->has('password') ? 'with-error' : null }}"
                                        >
                                    </div>

                                    @if ($errors->has('user.password_confirmation'))
                                        <label id="password-input-error" class="form-item__error" for="password-input">{{ $errors->first('user.password_confirmation') }}</label>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endguest
    </div>
</div>
