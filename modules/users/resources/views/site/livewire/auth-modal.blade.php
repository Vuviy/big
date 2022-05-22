<div class="modal-content" @mousedown.away="isShow && close($event)">
    <div x-data="app.alpine.tabs({ container: 'tabsContainer', nowOpen: 'auth' })">
        <div class="tabs-container"
             x-ref="tabsContainer"
             x-on:update.window.debounce="resize()"
             @open-modal.window.debounce.150="resize()"
             @resize.window.debounce.50="resize()"
        >
            <div
                    x-ref="auth"
                    x-show.transition.opacity.0.duration.300ms="isOpen('auth')"
            >
                <div x-data="app.alpine.tabs({ container: 'container', nowOpen: 'login', align: true })"
                     x-init="$watch('nowOpen', () => setTimeout(() => { $parent.resize() }, 300));setTimeout(() => { moveUnderline() }, 300)"
                     @open-tab.window="open($event.detail.name)"

                >
                    <div class="tabs__header _mb-xs"
                         x-ref="tabsHeader"
                    >
                        <div class="tabs__header-inner">
                            <button
                                    type="button"
                                    class="tabs__button button"
                                    :class="{ 'is-active': isOpen('login') }"
                                    @click="$parent.open('auth'); open('login')"
                                    x-ref="button-login"
                            >
                               <span class="button__text _fz-xs">
                                   @lang('cms-users::site.Вход')
                               </span>
                            </button>
                            <button
                                    type="button"
                                    class="tabs__button button"
                                    :class="{ 'is-active': isOpen('register') }"
                                    @click="$parent.open('auth'); open('register');"
                                    x-ref="button-register"
                            >
                               <span class="button__text _fz-xs">
                                   @lang('cms-users::site.Регистрация')
                               </span>
                            </button>
                        </div>
                        <div class="tabs__bottom-line" x-ref="underline"></div>
                    </div>

                    <div style="position:relative">
                        <div class="_mb-sm" x-ref="container">
                            <div x-ref="login"
                                 x-show.transition.opacity.0.duration.400ms="isOpen('login')">
                                <livewire:users.login-form :redirect="$redirect"/>
                            </div>

                            <div x-ref="register"
                                 x-show.transition.opacity.0.duration.400ms="isOpen('register')"
                                 style="display: none"
                            >
                                <livewire:users.register/>
                            </div>
                        </div>
                    </div>

                    @widget('cabinet-auth-socials')

                    <div class="_flex _justify-center _mb-xs">
                        <button x-show.transition.opacity.0.duration.300ms="isOpen('register')">
                           <span class="_flex _flex-column _items-center">
                               <span class="text _fz-xs _color-black">@lang('cms-users::site.Уже есть аккаунт?')</span>
                               <span class="link _fz-xs _color-pantone-gray _underline" @click="open('login')">
                                   <span class="link__text">
                                        @lang('cms-users::site.Войти').
                                   </span>
                               </span>
                           </span>
                        </button>
                        <button x-show.transition.opacity.0.duration.300ms="isOpen('login')">
                           <span class="_flex _flex-column _items-center">
                               <span class="text _fz-xs _color-black">@lang('cms-users::site.Еще нет аккаунта?')</span>
                               <span class="link _fz-xs _color-pantone-gray _underline" @click="open('register')">
                                   <span class="link__text">
                                       @lang('cms-users::site.Зарегистрироваться').
                                   </span>
                               </span>
                           </span>
                        </button>
                    </div>
                </div>
            </div>
            <div
                    x-ref="reset"
                    x-show.transition.opacity.0.duration.300ms="isOpen('reset')"
                    style="display: none"
            >
                <div class="_flex _items-center _justify-between _mb-xs">
                    <div class="text _fz-xxs _fw-bold _uppercase _color-base-strong">
                        @lang('cms-users::site.Напомнить пароль')
                    </div>
                </div>
                <livewire:users.forgot-password />
                <div class="text _fz-xxxs _text-center _color-faint-strong _mb-xs">@lang('cms-users::site.или войти с помощью')</div>

                <div class="_grid _grid--2 _items-center _spacer _spacer--xs _mb-xs">
                    <div class="_cell _flex">
                        <a href="#" class="button button--theme-transparent-bordered _control-height-md _control-space-xs _b-r-sm _flex-grow">
                           <span class="button__text">
                               @lang('cms-users::site.facebook')
                           </span>
                            <span class="button__icon button__icon--right">
                                @svg('socials', 'facebook', 20)
                           </span>
                        </a>
                    </div>
                    <div class="_cell _flex">
                        <a href="#" class="button button--theme-transparent-bordered _control-height-md _control-space-xs _b-r-sm _flex-grow">
                           <span class="button__text">
                               @lang('cms-users::site.google')
                           </span>
                            <span class="button__icon button__icon--right">
                                @svg('socials', 'google', 20)
                           </span>
                        </a>
                    </div>
                </div>

                <div x-show.transition.opacity.0.duration.300ms="isOpen('login')" class="_flex _flex-column _items-center">
                    <span class="_flex _flex-column _items-center">
                        <span class="text _fz-xs _color-black">@lang('cms-users::site.Еще нет аккаунта?')</span>
                        <span class="link _fz-xs _color-pantone-gray _underline" @click="open('auth');$dispatch('open-tab', { name: 'register' })">
                            <span class="link__text">
                                @lang('cms-users::site.Зарегистрироваться').
                            </span>
                        </span>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
